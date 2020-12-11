<?php

namespace App\Traits;

use Exception;
use SimpleXMLElement;

trait XmlTrait
{

    /**     
     *
     * @param string $path
     * @return SimpleXMLElement
     */
    protected function createXmlFromFile(string $path): SimpleXMLElement
    {        
        $xmlString = file_get_contents($path);
        return $this->createXmlFromString($xmlString);
    }

    /**          
     * @param string $xmlString
     * @return SimpleXMLElement
     */
    protected function createXmlFromString(string $xmlString): SimpleXMLElement
    {
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($xmlString);

        if (false === $xml) {
            $errorMessage = '';
            foreach (libxml_get_errors() as $error) {
                $errorMessage .= $error->message;
            }

            throw new Exception($errorMessage);
        }

        return $xml;
    }
}
