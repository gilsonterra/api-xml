<?php

namespace App\Services;

use App\Models\Importations;
use App\Models\Items;
use App\Models\Shiporders;
use SimpleXMLElement;

final class ShipordersImportService extends AbstractImportService
{
    /**     
     *
     * @param SimpleXMLElement $xml
     * @return void
     */
    public function import(Importations $importation): void
    {
        $importation->update(['status' => Importations::IMPORTING]);

        $success = 0;
        $errors = 0;
        $xml = $this->createXmlFromFile($importation->path);

        foreach ($xml as $objectXml) {                    
            $shipOrder = Shiporders::firstOrNew([
                'id' => (int) $objectXml->orderid
            ]);                   
            $shipOrder->person_id = (int) $objectXml->orderperson;
            $shipOrder->shipto_name = (string) $objectXml->shipto->name;
            $shipOrder->shipto_address = (string) $objectXml->shipto->address;
            $shipOrder->shipto_city = (string) $objectXml->shipto->city;
            $shipOrder->shipto_country = (string) $objectXml->shipto->country;
            $shipOrder->save();
            $success++;

            $importation->update(['success' => $success]);            

            foreach ($objectXml->items as $itemsXml) {
                Items::where('shiporder_id', $shipOrder->id)->delete();
                foreach ($itemsXml->item as $item) {
                    $item = new Items();
                    $item->title = (string) $item->title;
                    $item->note = (string) $item->note;
                    $item->quantity = (float) $item->quantity;
                    $item->price = (float) $item->price;

                    $shipOrder->items()->save($item);
                }
            }           
        }

        $status = $errors > 0 ? Importations::IMPORTED_WITH_ERROR : Importations::IMPORTED_WITH_SUCCESS;
        $importation->update(['status' => $status]);
    }
}
