<?php

namespace App\Console\Commands;

use App\Models\ReturnOrder;
use Illuminate\Console\Command;

class ProcessReturnOrderPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-return-order-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ReturnOrder::where('status', ReturnOrder::STATUS_APPROVED)
        ->whereIN('dispute', ReturnOrder::DISPUTE_ARRAY)
        ->chunk(100, function ($returnOrders) {
            foreach ($returnOrders as $returnOrder) {
                // Process the return order payment
            }
        });

        
    }
}
