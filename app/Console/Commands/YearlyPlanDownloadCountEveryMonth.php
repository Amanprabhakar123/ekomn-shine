<?php

namespace App\Console\Commands;

use App\Models\CompanyPlan;
use App\Events\ExceptionEvent;
use Illuminate\Console\Command;
use App\Models\CompanyPlanPayment;
use Illuminate\Support\Facades\Log;
use App\Models\CompanyPlanPermission;

class YearlyPlanDownloadCountEveryMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:yearly-plan-download-count-every-month';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to reset the download count of yearly plan every month.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $start = microtime(true);
        $this->info('Processing reset download count yearly plan -' . now());
        try {
            CompanyPlanPayment::with('companyPlans', 'plan')
                ->whereHas('plan', function ($query) {
                    $query->where('duration', '365')->orWhere('duration', '90');
                })->whereHas('companyPlans', function ($query) {
                    $query->where('status', CompanyPlan::STATUS_ACTIVE);
                })->where('payment_status', CompanyPlanPayment::PAYMENT_STATUS_SUCCESS)
                ->chunk(100, function ($companyPlanPayments) {
                    foreach ($companyPlanPayments as $companyPlanPayment) {
                        $subscription_start_date = $companyPlanPayment->companyPlans->subscription_start_date->format('Y-m-d');
                        $subscription_end_date = $companyPlanPayment->companyPlans->subscription_end_date->format('Y-m-d');
                        $day_of_month =  $companyPlanPayment->companyPlans->subscription_start_date->format('d');
                        $renewal_dates = getMonthlyStartDates($subscription_start_date,  $subscription_end_date, $day_of_month);
                        $current_date = now()->format('Y-m-d');
                        if (in_array($current_date, $renewal_dates)) {
                            CompanyPlanPermission::where('company_id', $companyPlanPayment->company_id)->update(['download_count' => 0]);
                        }
                    }
                });
        } catch (\Exception $e) {
            $this->error('Error in processing reset download count yearly plan -' . $e->getMessage());
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            Log::error($e->getMessage(), $e->getTrace(), $e->getLine());
        }
        $end = microtime(true);
        $executionTime = round($end - $start, 2);
        $this->info('Processing reset download count yearly plan Completed -' . $executionTime . ' seconds');
    }
}
