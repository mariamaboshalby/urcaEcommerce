<?php

namespace App\Console\Commands;

use App\Services\ExternalProductSyncService;
use Illuminate\Console\Command;

class SyncExternalProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:sync {--url= : Custom API URL} {--token= : Custom API Bearer Token} {--force : Force sync even if recently updated}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize products from the configured external Products API automatically';

    /**
     * Execute the console command.
     */
    public function handle(ExternalProductSyncService $syncService): int
    {
        $this->info('بدء مزامنة وتحديث المنتجات من الـ API...');

        $url = $this->option('url');
        $token = $this->option('token');
        $force = $this->option('force');

        if (!$force && empty($url)) {
            $result = $syncService->syncIfStale(15);
        } else {
            $result = $syncService->sync($url, $token);
        }

        if ($result['success']) {
            $this->info($result['message']);
            return Command::SUCCESS;
        }

        $this->error($result['message']);
        return Command::FAILURE;
    }
}
