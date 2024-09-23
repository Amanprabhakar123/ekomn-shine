<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\MyShine;
use App\Models\ShineProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AssignShineJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $product;

    public function __construct(ShineProduct $product)
    {
        $this->product = $product;
    }

    public function handle()
    {
        if ($this->product->assigner_id) {
            return;
        }
        //
        $matchingProduct = ShineProduct::whereBetween('amount', [
            $this->product->amount * 0.9, 
            $this->product->amount * 1.1
        ])
        ->where('status', ShineProduct::STATUS_PENDING)
        ->where('id', '!=', $this->product->id)
        ->where('user_id', '!=', $this->product->user_id)
        ->first();

        if ($matchingProduct) {
            $this->product->assigner_id = $matchingProduct->user_id;
            $this->product->status = ShineProduct::STATUS_INPROGRESS;
            $this->product->save();

            $matchingProduct->assigner_id = $this->product->user_id;
            $matchingProduct->status = ShineProduct::STATUS_INPROGRESS;
            $matchingProduct->save();
        } else {
            if (now()->diffInHours($this->product->created_at) > 48) {
                $this->product->status = ShineProduct::STATUS_CANCELLED;
                $this->product->save();
            }
        }
    }
}
