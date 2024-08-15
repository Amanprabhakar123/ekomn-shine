<?php

namespace App\Http\Controllers\MsiSettingAdmin;

use App\Events\ExceptionEvent;
use App\Http\Controllers\Controller;
use App\Jobs\ExportMisReport;
use App\Models\QueueName;
use Illuminate\Support\Facades\Log;

class MisSettingController extends Controller
{
    /**
     * display the MIS settings
     *
     * @return \Illuminate\View\View
     */
    public function misSettingInventory()
    {
        $csvData = [];

        // After looping, dump all the collected SKUs and prices

        return view('dashboard.admin.mis-setting-inventory');
    }

    /**
     * display the MIS settings for CSV type
     *
     * @param  string  $type
     * @return \Illuminate\View\View
     */
    public function misReportExportCSV($type)
    {
        try {
            $email = auth()->user()->email;

            if ($type) {
                ExportMisReport::dispatch($type, $email)->onQueue(QueueName::ExportMisReport);

                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('MIS report is being generated. You will receive an email shortly.'),
                ]], __('statusCode.statusCode200'));
            }

        } catch (\Exception $e) {
            // Handle the exception here
            // Log the exception details and trigger an ExceptionEvent
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            dd($exceptionDetails);
            // Trigger the event
            // event(new ExceptionEvent($exceptionDetails));

            Log::error($e->getMessage(), $e->getTrace(), $e->getLine());
        }
    }
}
