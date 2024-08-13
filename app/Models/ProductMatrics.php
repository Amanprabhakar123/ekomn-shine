<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMatrics extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'view_count',
        'search_count',
        'click_count',
        'buy_now_or_add_to_cart_count',
        'add_to_inventory_count',
        'purchase_count',
        'download_count',
    ];
    const ACTIVITY_TYPE_VIEW = UserActivity::ACTIVITY_TYPE_VIEW;
    const ACTIVITY_TYPE_BUY_NOW_OR_ADD_TO_CART = UserActivity::ACTIVITY_TYPE_BUY_NOW_OR_ADD_TO_CART;
    const ACTIVITY_TYPE_ADD_TO_INVENTORY = UserActivity::ACTIVITY_TYPE_ADD_TO_INVENTORY;
    const ACTIVITY_TYPE_SEARCH = UserActivity::ACTIVITY_TYPE_SEARCH;
    const ACTIVITY_TYPE_CLICK = UserActivity::ACTIVITY_TYPE_CLICK; // not used 
    const ACTIVITY_TYPE_PURCHASE = UserActivity::ACTIVITY_TYPE_PURCHASE;
    const ACTIVITY_TYPE_DOWNLOAD = UserActivity::ACTIVITY_TYPE_DOWNLOAD;

    // Define the relationship with the product
    public function product()
    {
        return $this->belongsTo(ProductVariation::class, 'product_id', 'id');
    }

    /**
     * Get the activity type
     *
     * @param int $activityType
     * @return string
     */
    public static function getActivityType($activityType)
    {
        switch ($activityType) {
            case self::ACTIVITY_TYPE_VIEW:
                return 'view';
                break;
            case self::ACTIVITY_TYPE_BUY_NOW_OR_ADD_TO_CART:
                return 'buy_now_or_add_to_cart';
                break;
            case self::ACTIVITY_TYPE_ADD_TO_INVENTORY:
                return 'add_to_inventory';
                break;
            case self::ACTIVITY_TYPE_SEARCH:
                return 'search';
                break;
            case self::ACTIVITY_TYPE_CLICK:
                return 'click';
                break;
            case self::ACTIVITY_TYPE_PURCHASE:
                return 'purchase';
                break;
            case self::ACTIVITY_TYPE_DOWNLOAD:
                return 'download';
                break;
            default:
                return 'Unknown';
        }
    }
}
