<?php

namespace App\Models;

use App\Models\User;
use App\Models\CompanyDetail;
use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BuyerInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'product_id',
        'buyer_id',
        'added_to_inventory_at',
    ];

    /**
     * Get the company that owns the BuyerInventory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(CompanyDetail::class, 'company_id', 'id');
    }

    /**
     * Get the product that owns the BuyerInventory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(ProductVariation::class, 'product_id', 'id');
    }

    /**
     * Get the buyer that owns the BuyerInventory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id', 'id');
    }


}
