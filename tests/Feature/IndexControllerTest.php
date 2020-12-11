<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class IndexControllerTest extends TestCase
{
    public function testPostUploadFileIsEmpty()
    {
        $file = UploadedFile::fake()->createWithContent('test.xml', '');
        $response = $this->post('/upload', ['xml' => $file]);
        $response->assertSessionHas('error', 'File is empty.');        
    }

    public function testPostUploadXmlIsEmpty()
    {
        $content =  <<<XML
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

        $file = UploadedFile::fake()->createWithContent('test.xml', $content);
        $response = $this->post('/upload', ['xml' => $file]);
        $response->assertSessionHas('success');        
    }
}
