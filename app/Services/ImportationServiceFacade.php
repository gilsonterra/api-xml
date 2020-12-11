<?php

namespace App\Services;

use App\Models\Importations;
use Exception;

final class ImportationServiceFacade
{
    /**     
     * @param Importations $importations
     * @return void
     */
    public static function import(Importations $importation)
    {   
        switch ($importation->type) {
            case 'people':
                $service = new PeopleImportService($importation);                
                break;
            case 'shiporders':
                $service = new ShipordersImportService($importation);
                break;
            default:
                throw new Exception('Type of xml is invalid.');
                break;
        }

        return $service->import();
    }
}