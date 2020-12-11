<?php

namespace App\Jobs;

use App\Models\Importations;
use App\Services\ImportationServiceFacade;
use App\Services\ImportationsProcessor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessImportations implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     *
     * @var \App\Models\Importations
     */
    protected $importation;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Importations $importation)
    {
        $this->importation = $importation;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ImportationServiceFacade::import($this->importation);       
    }
}
