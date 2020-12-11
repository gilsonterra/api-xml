<?php

namespace App\Services;

use App\Models\Importations;
use App\Models\People;
use App\Models\Phones;
use Exception;
use SimpleXMLElement;

final class PeopleImportService extends AbstractImportService
{
    /**          
     * @return void
     */
    public function import(): void
    {
        try {
            $this->updateStatus(Importations::IMPORTING);
            $xml = $this->createXmlFromFile($this->importation->path);

            foreach ($xml as $personXml) {
                $this->importPerson($personXml);
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
     * @param SimpleXMLElement $personXml
     * @return People
     */
    private function importPerson(SimpleXMLElement $personXml): void
    {
        try {
            $person = People::firstOrNew([
                'id' => (int) $personXml->personid
            ]);
            $person->name = (string) $personXml->personname;

            if ($person->save()) {
                $this->addCountSuccess();
                $this->importPhones($person, $personXml->phones);
            }
        } catch (Exception $exception) {
            $this->addCountError();
            $this->updateNotes($exception->getMessage());
        }
    }

    /**
     *
     * @param People $person
     * @param SimpleXMLElement $phones
     * @return void
     */
    private function importPhones(People $person, SimpleXMLElement $phones): void
    {
        foreach ($phones as $phoneXml) {
            Phones::where('person_id', $person->id)->delete();
            foreach ($phoneXml->phone as $number) {
                $phone = new Phones();
                $phone->number = (string) $number;

                // check number
                if (!is_numeric($phone->number)) {
                    $this->updateNotes(sprintf("Person ID: '%s' with phone number '%s' invalid.", $person->id, $phone->number));
                    continue;
                }

                $person->phones()->save($phone);
            }
        }
    }
}
