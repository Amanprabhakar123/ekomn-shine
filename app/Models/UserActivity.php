<?php

namespace App\Models;

use App\Models\User;
use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserActivity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'active',
        'activity_type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    const ACTIVITY_TYPE_VIEW = 1;
    const ACTIVITY_TYPE_BUY_NOW_OR_ADD_TO_CART = 2;
    const ACTIVITY_TYPE_ADD_TO_INVENTORY = 3;
    const ACTIVITY_TYPE_SEARCH = 4;
    const ACTIVITY_TYPE_CLICK = 5; // not used
    const ACTIVITY_TYPE_PURCHASE = 6;
    const ACTIVITY_TYPE_DOWNLOAD = 7;

    const IS_ACTIVE_TRUE = 1;
    const IS_ACTIVE_FALSE = 2;

    // Define the relationship with the user Buyer
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Define the relationship with the product
    public function product()
    {
        return $this->belongsTo(ProductVariation::class, 'product_id', 'id');
    }

    // Get the activity type
    public function getActivityType($activityType)
    {
        switch ($activityType) {
            case self::ACTIVITY_TYPE_VIEW:
                return 'View';
                break;
            case self::ACTIVITY_TYPE_BUY_NOW_OR_ADD_TO_CART:
                return 'Buy Now Or Add to Cart';
                break;
            case self::ACTIVITY_TYPE_ADD_TO_INVENTORY:
                return 'Add to Inventory';
                break;
            case self::ACTIVITY_TYPE_SEARCH:
                return 'Search';
                break;
            case self::ACTIVITY_TYPE_CLICK:
                return 'Click';
                break;
            case self::ACTIVITY_TYPE_PURCHASE:
                return 'Purchase';
                break;
            case self::ACTIVITY_TYPE_DOWNLOAD:
                return 'Download';
                break;
            default:
                return 'Unknown';
        }
    }
    
}
