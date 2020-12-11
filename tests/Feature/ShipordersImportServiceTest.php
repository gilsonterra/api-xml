<?php

namespace Tests\Feature;

use App\Models\Importations;
use App\Models\People;
use App\Services\ShipordersImportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ShipordersImportServiceTest extends TestCase
{
    use RefreshDatabase;

    /**     
     *
     * @return People
     */
    private function createPerson(): People
    {
        $person = new People();
        $person->name = 'PERSON TESTE';
        $person->save();

        return $person;
    }

    private function callImport(string $contentXml = '')
    {
        $person = $this->createPerson();
        $contentXmlWithPersonId = str_replace('[:person_id:]', $person->id, $contentXml);
        $xmlFile = UploadedFile::fake()->createWithContent('test.xml', $contentXmlWithPersonId);
        
        $importation = new Importations();
        $importation->path = $xmlFile->getRealPath();
        $importation->file = "TEST";
        $importation->total = 0;
        $importation->save();

        $service = new ShipordersImportService($importation);
        $service->import();    
        
        return $importation;
    }

    public function testImportXmlWithTwoShipordersAndOneWithError()
    {
        $contentXml = <<<XML
        <?xml version="1.0" encoding="utf-8"?>
        <shiporders>
            <shiporder>
                <orderid>1</orderid>
                <orderperson>[:person_id:]</orderperson>
                <shipto>
                    <name>Name 1</name>
                    <address>Address 1</address>
                    <city>City 1</city>
                    <country>Country 1</country>
                </shipto>
                <items>
                    <item>
                        <title>Title 1</title>
                        <note>Note 1</note>
                        <quantity>745</quantity>
                        <price>llll</price>
                    </item>
                </items>
            </shiporder>            
            <shiporder>
                <orderid>2</orderid>
                <orderperson>99999</orderperson>
                <shipto>
                    <name>Name 3</name>
                    <address>Address 3</address>
                    <city>City 3</city>
                    <country>Country 3</country>
                </shipto>
                <items>
                    <item>
                        <title>Title 3</title>
                        <note>Note 3</note>
                        <quantity>5</quantity>
                        <price>1.12</price>
                    </item>
                    <item>
                        <title>Title 4</title>
                        <note>Note 4</note>
                        <quantity>2</quantity>
                        <price>77.12</price>
                    </item>
                </items>
            </shiporder>
        </shiporders>
        XML;

        $importation = $this->callImport($contentXml);       
        $this->assertEquals(Importations::IMPORTED_WITH_ERROR, $importation->status);         
        $this->assertEquals(1, $importation->errors);
        $this->assertEquals(1, $importation->success);        
        $this->assertEquals("[1]", $importation->imported_ids);    
    }


    public function testImportXmlWithTwoShipordersSuccessfully()
    {
        $contentXml = <<<XML
        <?xml version="1.0" encoding="utf-8"?>
        <shiporders>
            <shiporder>
                <orderid>1</orderid>
                <orderperson>[:person_id:]</orderperson>
                <shipto>
                    <name>Name 1</name>
                    <address>Address 1</address>
                    <city>City 1</city>
                    <country>Country 1</country>
                </shipto>
                <items>
                    <item>
                        <title>Title 1</title>
                        <note>Note 1</note>
                        <quantity>745</quantity>
                        <price>llll</price>
                    </item>
                </items>
            </shiporder>            
            <shiporder>
                <orderid>2</orderid>
                <orderperson>[:person_id:]</orderperson>
                <shipto>
                    <name>Name 3</name>
                    <address>Address 3</address>
                    <city>City 3</city>
                    <country>Country 3</country>
                </shipto>
                <items>
                    <item>
                        <title>Title 3</title>
                        <note>Note 3</note>
                        <quantity>5</quantity>
                        <price>1.12</price>
                    </item>
                    <item>
                        <title>Title 4</title>
                        <note>Note 4</note>
                        <quantity>2</quantity>
                        <price>77.12</price>
                    </item>
                </items>
            </shiporder>
        </shiporders>
        XML;

        $importation = $this->callImport($contentXml);     
        $this->assertEquals(null, $importation->notes);     
        $this->assertEquals(Importations::IMPORTED_WITH_SUCCESS, $importation->status);         
        $this->assertEquals(0, $importation->errors);
        $this->assertEquals(2, $importation->success);                       
        $this->assertEquals("[1,2]", $importation->imported_ids); 
    }
}
