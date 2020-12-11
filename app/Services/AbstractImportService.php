<?php

namespace App\Services;

use App\Models\Importations;
use App\Traits\XmlTrait;
use SimpleXMLElement;

abstract class AbstractImportService
{

    use XmlTrait;

    /**     
     *
     * @var array
     */
    private $errors = [];

    /**     
     *
     * @return array
     */
    protected function getErrors(): array
    {
        return $this->errors;
    }

    /**     
     *
     * @param string $message
     * @return void
     */
    protected function addErrors(string $message): void
    {
        array_push($this->errors, $message);
    }


    abstract public function import(Importations $importation): void;    
}
