<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\MyShine;
use App\Models\QueueName;
use App\Models\ShineProduct;
use App\Jobs\AssignShineJob;

class AssignShineProducts extends Command
{
    protected $signature = 'shine:assign-products';
    protected $description = 'Assign Shine products and process them';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Running the assign products command...'); // Add this line

        $products = ShineProduct::where('status', ShineProduct::STATUS_PENDING)
            ->where('assigner_id', null)
            ->get();

        foreach ($products as $product) {
            AssignShineJob::dispatch($product)->onQueue('assign_shine_job');
        }

        $this->info('Shine products assignment jobs dispatched.');
    }
}