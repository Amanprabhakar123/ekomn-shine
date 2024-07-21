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

    // Constants for Order Types
    const DROPSHIP = 'Dropship';
    const BULK_ORDER = 'Bulk Order';
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
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} charges with ID: {$this->id}");
    }


}
