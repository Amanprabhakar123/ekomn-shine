<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopProduct extends Model
{
    use HasFactory;

    const TYPE_PREMIUM_PRODUCT = 1;
    const TYPE_NEW_ARRIVAL = 2;
    const TYPE_IN_DEMAND = 3;
    const TYPE_REGULAR_AVAILABLE = 4;

    const TYPE_ARRAY = [
        self::TYPE_PREMIUM_PRODUCT => 'Premium',
        self::TYPE_NEW_ARRIVAL => 'New Arrival',
        self::TYPE_IN_DEMAND => 'In Demand',
        self::TYPE_REGULAR_AVAILABLE => 'Regular Available',
    ];
}
