<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install API setup';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('API installation complete!');
    }
}
