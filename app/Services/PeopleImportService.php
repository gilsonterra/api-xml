<?php

namespace App\Services;

use App\Models\Importations;
use App\Models\People;
use App\Models\Phones;
use SimpleXMLElement;

final class PeopleImportService extends AbstractImportService
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
            $person = People::firstOrNew([
                'id' => (int) $objectXml->personid
            ]);
            $person->name = (string) $objectXml->personname;            
            $person->save();
            $success++;

            $importation->update(['success' => $success]);            

            foreach ($objectXml->phones as $phoneXml) {
                Phones::where('person_id', $person->id)->delete();
                foreach ($phoneXml->phone as $number) {
                    $phone = new Phones();
                    $phone->number = (string) $number;
                    $person->phones()->save($phone);
                }
            }
        }

        $status = $errors > 0 ? Importations::IMPORTED_WITH_ERROR : Importations::IMPORTED_WITH_SUCCESS;
        $importation->update(['status' => $status]);
    }
}
