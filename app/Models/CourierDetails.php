<?php

namespace App\Models;

use App\Models\ReturnShipment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourierDetails extends Model
{
    use HasFactory;

    protected $fillable = ['courier_name', 'tracking_url'];
    

    /**
     * Get all of the shipments for the CourierDetails
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function returnShipment()
    {
        return $this->hasMany(ReturnShipment::class, 'courier_id', 'id');
    }
}
