<?php

namespace App\Traits;

use App\Models\Receipt;
use Illuminate\Support\Facades\DB;

trait ReceiptIdGenerator
{
    public function getNextReceiptId($buyerTempId = null)
    {
        return DB::transaction(function () use ($buyerTempId) {
            $nextReceiptId = null;
            if ($buyerTempId) {
                $receipt = Receipt::lockForUpdate()->where('buyer_temp_id', $buyerTempId)->first();
                if (empty($receipt)) {
                    $receipt = Receipt::create(['last_receipt_id' => 1, 'buyer_temp_id' => $buyerTempId]); // Start from 1000
                    $nextReceiptId = $receipt->id;
                    $receipt->last_receipt_id = $nextReceiptId;
                    $receipt->save();
                }else{
                    $nextReceiptId = $receipt->last_receipt_id;
                    $receipt->last_receipt_id = $nextReceiptId;
                    $receipt->save();
                }
            } else {
                $receipt = Receipt::lockForUpdate()->first();
                if (empty($receipt)) {
                    $receipt = Receipt::create(['last_receipt_id' => 1]); // Start from 1000
                    $nextReceiptId = $receipt->id;
                    $receipt->last_receipt_id = $nextReceiptId;
                    $receipt->save();
                }
                
            }
            return $nextReceiptId;
        });
    }
}
