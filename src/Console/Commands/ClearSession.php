<?php

/*
 *  Copyright © All Rights Reserved by Vizrex (Private) Limited 
 *  Usage or redistribution of this code is strictly prohibited
 *  without written consent of Vizrex (Private) Limited.
 *  Queries are welcomed at copyright@vizrex.com
 */

namespace Vizrex\LaravelCleaner\Console\Commands;

use RuntimeException;
use Illuminate\Filesystem\Filesystem;
use \Vizrex\Laraviz\Console\Commands\BaseCommand;
use \Vizrex\LaravelCleaner\LaravelCleanerProvider;

class ClearSession extends BaseCommand
{    
        
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'session:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all session files';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new config clear command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $path = storage_path("framework/sessions");

        if (! $path) {
            throw new RuntimeException($this->str("path_not_found", ["path" => "Session"]));
        }

        foreach ($this->files->glob("{$path}/*") as $session) {
            $this->files->delete($session);
        }

        $this->info($this->str("cleared", ["type" => "Session"]));
    }
    
    protected function setNamespace()
    {
        $this->namespace = LaravelCleanerProvider::getNamespace();
    }
}
