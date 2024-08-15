<?php

namespace App\Jobs;

use App\Services\ExportServices;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExportMisReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $type;

    protected $email;

    /**
     * Create a new job instance.
     */
    public function __construct($type, $email)
    {
        $this->type = $type;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $fileName = 'MIS_Report.csv';
            $csvData = [];
            $csvHeaders = [];
            $email = $this->email;
            if ($this->type == 'in_demand') {
                $csvHeaders = ['Title', 'HSN', 'SKU', 'Stock', 'Status', 'Purchase Count', 'Company Serial ID'];
                // Fetch products in chunks
                DB::table('product_inventories as pi')
                    ->join('product_variations as pv', 'pi.id', '=', 'pv.product_id')
                    ->join('product_matrics as pm', 'pi.id', '=', 'pm.product_id')
                    ->join('company_details as cd', 'pv.company_id', '=', 'cd.id')
                    ->select(
                        'pi.title',
                        'pi.hsn',
                        'pv.sku',
                        'pv.stock',
                        'pv.status',
                        'pm.purchase_count',
                        'cd.company_serial_id'
                    )
                    ->chunk(100, function ($products) use (&$csvData) {
                        foreach ($products as $product) {
                            $csvData[] = [
                                $product->title,
                                $product->hsn,
                                $product->sku,
                                $product->stock,
                                $product->status,
                                $product->purchase_count,
                                $product->company_serial_id,
                            ];
                        }
                    });

            }
            // Call the ExportFileService and pass the $csvData and $this->email as parameters
            $exportFileService = new ExportServices;
            $exportFileService->sendCSVByEmail($csvHeaders, $csvData, $fileName, $email);

        } catch (\Exception $e) {
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger an event or just log the error
            // event(new ExceptionEvent($exceptionDetails));

            Log::error('ExportMisReport Job Error: '.$e->getMessage(), [
                'exception' => $e,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
        }
    }
}
