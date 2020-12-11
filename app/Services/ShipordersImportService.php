<?php

namespace App\Services;

use App\Models\Importations;
use App\Models\Items;
use App\Models\People;
use App\Models\Shiporders;
use Exception;
use SimpleXMLElement;

final class ShipordersImportService extends AbstractImportService
{
    /**          
     * @return void
     */
    public function import(): void
    {
        try {
            $this->updateStatus(Importations::IMPORTING);
            $xml = $this->createXmlFromFile($this->importation->path);

            foreach ($xml as $shipOrderXml) {
                $this->importShipOrder($shipOrderXml);
            }            

            $this->updateStatus($this->importation->errors > 0 ? Importations::IMPORTED_WITH_ERROR : Importations::IMPORTED_WITH_SUCCESS);
        } catch (Exception $exception) {
            $this->addCountError();
            $this->updateNotes($exception->getMessage());
            $this->updateStatus(Importations::IMPORTED_WITH_ERROR);            
        }
    }

    /**     
     *
     * @param SimpleXMLElement $shipOrderXml
     * @return void
     */
    private function importShipOrder(SimpleXMLElement $shipOrderXml)
    {
        try {
            $shipOrder = Shiporders::firstOrNew([
                'id' => (int) $shipOrderXml->orderid
            ]);

            $shipOrder->person_id = (int) $shipOrderXml->orderperson;

            // Check if person exist in database           
            if(!People::find($shipOrder->person_id)){                
                throw new Exception(sprintf("The ShipOrder with ID '%s' have no person with ID '%s' registered.", $shipOrder->id, $shipOrder->person_id));
            }

            $shipOrder->shipto_name = (string) $shipOrderXml->shipto->name;
            $shipOrder->shipto_address = (string) $shipOrderXml->shipto->address;
            $shipOrder->shipto_city = (string) $shipOrderXml->shipto->city;
            $shipOrder->shipto_country = (string) $shipOrderXml->shipto->country;

            if ($shipOrder->save()) {
                $this->addCountSuccess();         
                $this->importItems($shipOrder, $shipOrderXml->items);       
            }
        } catch (Exception $exception) {
            $this->addCountError();
            $this->updateNotes($exception->getMessage());            
        }
    }

    /**     
     *
     * @param Shiporders $shiporder
     * @param SimpleXMLElement $items
     * @return void
     */
    private function importItems(Shiporders $shiporder, SimpleXMLElement $items): void
    {
        foreach ($items as $itemsXml) {                        
            foreach ($itemsXml->item as $itemXml) {
                $item = new Items();
                $item->title = (string) $itemXml->title;
                $item->note = (string) $itemXml->note;
                $item->quantity = (float) $itemXml->quantity;
                $item->price = (float) $itemXml->price;

                // validations
                if (!is_numeric($item->quantity)) {
                    $this->updateNotes(sprintf("ShipOrder ID: '%s' with quantity '%s' is invalid.", $shiporder->id, $item->quantity));
                    continue;
                }

                if (!is_float($item->price)) {
                    $this->updateNotes(sprintf("ShipOrder ID: '%s' with price '%s' is invalid. Float is expected.", $shiporder->id, $item->price));
                    continue;
                }

                $shiporder->items()->save($item);
            }
        }
    }
}
