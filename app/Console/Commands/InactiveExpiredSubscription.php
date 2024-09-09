<?php

namespace App\Console\Commands;

use App\Models\CompanyPlan;
use App\Models\CompanyPlanPayment;
use Illuminate\Console\Command;

class InactiveExpiredSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:inactive-expired-subscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inactive expired subscription';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $start = microtime(true);
        $this->info('Inactive expired plan: ' . now());
        CompanyPlan::where('subscription_end_date', '<', now())
        ->where('status', CompanyPlan::STATUS_ACTIVE)
        ->update(['status' => CompanyPlan::STATUS_INACTIVE]); 
        $end = microtime(true);
        $executionTime = round($end - $start, 2);
        $this->info('Expired plan inactive . Total execution time: ' . $executionTime . ' seconds.');
    }
}
