<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\ImportCatalogueService;
use Illuminate\Support\Facades\File;

class CatalogImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'catalog:import {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importing of the directory from the file';
    
    /**
     * @var ImportCatalogueService
     */
    protected $importService = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ImportCatalogueService $importService)
    {
        parent::__construct();
        
        $this->importService = $importService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file = $this->argument('file');
        
        $json = File::get($file);
        
        $this->info('Importing from "' . $file . '"');
        $this->importService->importJson($json);
        
        $this->info('Catalogue was imported successfull');
       
    }
}
