<?php

namespace App\Services;

use App\Models\Importations;
use App\Traits\XmlTrait;

abstract class AbstractImportService
{

    use XmlTrait;

    private const COLUMN_SUCCESS = 'success';
    private const COLUMN_ERROR = 'errors';

    /**     
     * @var App\Models\Importations
     */
    protected $importation;

    /**
     *
     * @param Importations $importation
     */
    public function __construct(Importations $importation)
    {
        $this->importation = $importation;
    }

    /**
     *
     * @param Importations $importation
     * @param string $newNote
     * @return boolean
     */
    protected function updateNotes(string $newNote): bool
    {
        $note = $this->importation->notes . ' ' . $newNote;
        return $this->importation->update(['notes' => $note]);
    }

    /**
     *
     * @param string $status
     * @return void
     */
    protected function updateStatus(string $status)
    {
        return $this->importation->update(['status' => $status]);
    }

    /**     
     *
     * @param Importations $importation
     * @param string $columnName
     * @return boolean
     */
    private function addCount(string $columnName): bool
    {
        $count = intval($this->importation[$columnName]) + 1;
        return $this->importation->update([$columnName => $count]);
    }

    /**
     *
     * @param Importations $importation
     * @return bool
     */
    protected function addCountSuccess(): bool
    {
        return $this->addCount(self::COLUMN_SUCCESS);
    }

    /**    
     *
     * @param Importations $importation
     * @return bool
     */
    protected function addCountError(): bool
    {
        return $this->addCount(self::COLUMN_ERROR);
    }

    /**     
     *
     * @param Importations $importation
     * @return void
     */
    abstract public function import(): void;    
}
