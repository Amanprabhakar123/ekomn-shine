<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Charges extends Model
{
    use HasFactory, LogsActivity;

    // Constants for Other Charges
    const SHIPPING_CHARGES = 'Shipping charges';
    const PACKING_CHARGES = 'Packing charges';
    const LABOUR_CHARGES = 'Labour Charges';
    const PROCESSING_CHARGES = 'Processing Charges';
    const REFERRAL_CHARGES = 'Referral Charges';

    // Constants for Order Types
    const DROPSHIP = 'Dropship';
    const BULK = 'Bulk';
    const RESELL = 'Resell';

    // GST Bracket Constant
    const GST_BRACKET = '18%';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'other_charges',
        'hsn',
        'gst_bracket',
        'category',
        'range',
        'value',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'range' => 'string',
        'value' => 'string',
    ];

    /**
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'other_charges',
                'hsn',
                'gst_bracket',
                'category',
                'range',
                'value',
            ])
            ->logOnlyDirty()
            ->useLogName('Charges Log')
            ->setDescriptionForEvent(fn (string $eventName) => "{$eventName} charges with ID: {$this->id}");
    }

    /**
     * Get the charges by category.
     *
     * @param string $category
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function getValueByOrderTypeAndCharge($orderType, $charge)
    {
        return self::where('category', $orderType)->where('other_charges', $charge);
    }

    /**
     * Get the charges by category.
     *
     * @param string $category
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function getValueBasedOnAmount($ranges, $amount)
    {
        try {
            foreach ($ranges as $range) {
                if ($range['range'] == ">1000") {
                    if ($amount > 1000) {
                        return $range['value'];
                    }
                } else {
                    $array = explode(' to ', $range['range']);
                    if (count($array) > 1) {
                        list($min, $max) = explode(' to ', $range['range']);
                        if ($amount >= $min && $amount <= $max) {
                            return $range['value'];
                        }
                    } else {
                        if ($amount >= $range['range']) {
                            return $range['value'];
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            throw  $e;
        }
        // If the amount exceeds all ranges, return the value of the maximum range
        $lastRange = end($ranges);
        return $lastRange['value'];
    }

    /**
     * Get the order type.
     *
     * @return int
     */
    public function getOrderType(): int
    {
        switch ($this->order_type) {
            case self::DROPSHIP:
                return 1;
            case self::BULK:
                return 2;
            case self::RESELL:
                return 3;
            default:
                return 'Unknown';
        }
    }
}
