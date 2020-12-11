<?php

namespace App\Services;

use SplFileInfo;
use App\Jobs\ProcessImportations;
use App\Models\Importations;
use App\Traits\XmlTrait;
use DateTime;
use Exception;
use Illuminate\Http\UploadedFile;
use PhpParser\Node\Stmt\Break_;

final class ImportationsProcessor
{

    use XmlTrait;

    /**          
     * @param UploadedFile $file
     * @return string
     */
    private function createNewNameFile(UploadedFile $file): string
    {
        $now = new DateTime();
        return sprintf('%s_%s', $now->format('YmdHmi'), $file->getClientOriginalName());
    }

    /**     
     *
     * @param UploadedFile $file
     * @return SplFileInfo
     */
    private function importFileToStorage(UploadedFile $file): SplFileInfo
    {
        $destinationPath = storage_path('app/uploads');
        $newNameFile = $this->createNewNameFile($file);
        return $file->move($destinationPath, $newNameFile);
    }


    /**          
     * @param UploadedFile $file
     * @return Importations
     */
    public function createProcessFromXmlFile(UploadedFile $file): Importations
    {
        try {
            $xmlString = file_get_contents($file);

            if (empty($xmlString)) {
                throw new Exception('File is empty.');
            }

            $xmlObject = $this->createXmlFromString($xmlString);
            $fileImported = $this->importFileToStorage($file);


            $importations = Importations::create([
                'file' => $fileImported->getFilename(),
                'path' => storage_path('app/uploads/') . $fileImported->getFilename(),
                'status' => Importations::PENDING,
                'type' => $xmlObject->getName(),
                'total' => $xmlObject->children()->count()
            ]);

            ProcessImportations::dispatch($importations); // call Job
            return $importations;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     *
     * @param Importations $importations
     * @return void
     */
    public function importRegisters(Importations $importation)
    {
        switch ($importation->type) {
            case 'people':
                $service = new PeopleImportService();
                break;
            case 'shiporders':
                $service = new ShipordersImportService();
                break;
            default:
                throw new Exception('Type of xml is invalid.');
                break;
        }

        $service->import($importation);
    }
}
