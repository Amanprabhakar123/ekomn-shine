<?php

namespace App\Http\Controllers\MsiSettingAdmin;

use App\Events\ExceptionEvent;
use App\Http\Controllers\Controller;
use App\Jobs\ExportMisReport;
use App\Models\Order;
use App\Models\QueueName;
use App\Models\User;
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

        return view('dashboard.admin.mis-setting-inventory');
    }

    /**
     * Display the view for MIS setting order.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function misSettingOrder()
    {
        return view('dashboard.admin.mis-setting-order');
    }

    /**
     * Display the view for MIS setting supplier.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function misSettingSupplier()
    {
        return view('dashboard.admin.mis-setting-supplier');
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
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_MIS_SETTING_INVENTORY)) {
                return response()->json([
                    'data' => [
                        'statusCode' => __('statusCode.statusCode403'), // HTTP status code 403 (Forbidden)
                        'status' => __('statusCode.status403'), // Status message for forbidden operation
                        'message' => __('You are not authorized to perform this operation.'), // Informative message
                    ],
                ], __('statusCode.statusCode403')); // HTTP status code 403 (Forbidden)
            }
            // Get the email address of the currently authenticated user
            $email = auth()->user()->email;

            // Check if the type parameter is provided
            if ($type) {
                // Dispatch the ExportMisReport job to the specified queue with the report type and user email
                ExportMisReport::dispatch($type, $email)
                    ->onQueue(QueueName::ExportMisReport);

                // Return a JSON response indicating that the report generation process has started
                return response()->json([
                    'data' => [
                        'statusCode' => __('statusCode.statusCode200'), // HTTP status code 200 (OK)
                        'status' => __('statusCode.status200'), // Status message for successful operation
                        'message' => __('MIS report is being generated. You will receive an email shortly.'), // Informative message
                    ],
                ], __('statusCode.statusCode200')); // HTTP status code 200 (OK)
            }

        } catch (\Exception $e) {
            // Handle any exceptions that occur during the report generation process

            // Prepare exception details for logging or further processing
            $exceptionDetails = [
                'message' => $e->getMessage(), // Exception message
                'file' => $e->getFile(), // File where the exception occurred
                'line' => $e->getLine(), // Line number where the exception occurred
            ];
            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            // Log the exception details for debugging and monitoring
            Log::error($e->getMessage(), $e->getTrace(), $e->getLine());
        }
    }
}
