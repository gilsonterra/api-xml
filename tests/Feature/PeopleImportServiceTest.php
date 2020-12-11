<?php

namespace Tests\Feature;

use App\Models\Importations;
use App\Services\PeopleImportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PeopleImportServiceTest extends TestCase
{
    use RefreshDatabase;


    private function callImport(string $contentXml = '')
    {
        $xmlFile = UploadedFile::fake()->createWithContent('test.xml', $contentXml);

        $importation = new Importations();
        $importation->path = $xmlFile->getRealPath();
        $importation->file = "TEST";
        $importation->total = 0;
        $importation->save();

        $service = new PeopleImportService($importation);
        $service->import();

        return $importation;
    }


    public function testImportXmlSuccessfully()
    {
        $contentXml = <<<XML
        <?xml version="1.0" encoding="utf-8"?>
        <people>
            <person>
                <personid>1</personid>
                <personname>Name 1</personname>
                <phones>
                    <phone>2345678</phone>
                    <phone>1234567</phone>
                </phones>
                </person>
            <person>
                <personid>2</personid>
                <personname>Name 2</personname>
                <phones>
                    <phone>4444444</phone>
                </phones>
            </person>
            <person>
                <personid>3</personid>
                <personname>Name 3</personname>
                <phones>
                    <phone>7777777</phone>
                    <phone>8888888</phone>
                </phones>
            </person>                       
        </people>
        XML;

        $importation = $this->callImport($contentXml);
        $this->assertEquals(null, $importation->notes);
        $this->assertEquals(Importations::IMPORTED_WITH_SUCCESS, $importation->status);
        $this->assertEquals(0, $importation->errors);
        $this->assertEquals(3, $importation->success);
        $this->assertEquals("[1,2,3]", $importation->imported_ids);
    }
}
