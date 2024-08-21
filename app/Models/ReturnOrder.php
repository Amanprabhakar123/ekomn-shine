<?php

namespace App\Models;

use App\Models\Order;
use App\Models\ReturnComment;
use App\Models\ReturnShipment;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReturnOrder extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'return_number',
        'return_date',
        'status',
        'dispute',
        'file_path',
        'reason'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'return_date' => 'datetime'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    const STATUS_OPEN = 1;
    const STATUS_IN_PROGRESS = 2;
    const STATUS_ACCEPTED = 3;
    const STATUS_APPROVED = 4;
    const STATUS_REJECTED = 5;

    const DISPUTE_NO = 0;
    const DISPUTE_YES = 1;

    protected $hidden = [
        'deleted_at',
    ];

    const STATUS_ARRAY = [
        self::STATUS_OPEN => 'Open',
        self::STATUS_IN_PROGRESS => 'In Progress',
        self::STATUS_ACCEPTED => 'Accepted',
        self::STATUS_APPROVED => 'Approved',
        self::STATUS_REJECTED => 'Decline',
    ];

    const RETURN_RESON = [
        '1' => 'Product Not Delivered',
        '2' => 'Defective Product',
        '3' => 'Incorrect Quantity Delivered',
        '4' => 'Wrong product Delivered',
        '5' => 'Others',
    ];

     /**
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
           'order_id',
            'return_number',
            'return_date',
            'status',
            'dispute',
            'file_path',
            'reason'
        ])
        ->logOnlyDirty()
        ->useLogName('Return Order Log')
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} return order with ID: {$this->id}");
    }


    /**
     * Get the order that owns the ReturnOrder
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    /**
     * Get all of the returnShipments for the ReturnOrder
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function returnShipments()
    {
        return $this->hasMany(ReturnShipment::class, 'return_id', 'id');
    }


    /**
     * Get all of the returnComments for the ReturnOrder
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function returnComments()
    {
        return $this->hasMany(ReturnComment::class, 'return_id', 'id');
    }
    

    /**
     * Generate a unique return number
     *
     * @return string
     */
    public function generateReturnNumber()
    {
        $returnNumber = 'RET'.mt_rand(1000000000, 9999999999);
        while (self::where('return_number', $returnNumber)->exists()) {
            $returnNumber = 'RET'.mt_rand(1000000000, 9999999999);
        }
        return $returnNumber;
    }

    /**
     * Get the status attribute
     *
     * @param  string  $value
     * @return string
     */
    public function getStatusAttribute($value)
    {
        return self::STATUS_ARRAY[$value];
    }

    /**
     * Get the reason attribute
     *
     * @param  string  $value
     * @return string
     */  
    public function reason($value)
    {
        return self::RETURN_RESON[$value];
    }


    /**
     * Get the status attribute
     *
     * @param  string  $value
     * @return string
     */
    public function getStatus(): string
    {
        switch ($this->status) {
            case self::STATUS_OPEN:
                return 'Open';
            case self::STATUS_IN_PROGRESS:
                return 'In Progress';
            case self::STATUS_ACCEPTED:
                return 'Accepted';
            case self::STATUS_APPROVED:
                return 'Approved';
            case self::STATUS_REJECTED:
                return 'Rejected';
            default:
                return 'Unknown';
        }
    }

    /**
     * Get the dispute attribute
     *
     * @param  string  $value
     * @return string
     */
    public function getDisputeAttribute($value)
    {
        return $value == self::DISPUTE_YES ? 'Yes' : 'No';
    }

    /**
     * Get the dispute attribute
     *
     * @param  string  $value
     * @return string
     */
    public function getDispute(): string
    {
        return $this->dispute == self::DISPUTE_YES ? 'Yes' : 'No';
    }

    /**
     * Check if the return order is disputed
     *
     * @return bool
     */
    public function isDisputed(): bool
    {
        return $this->dispute == self::DISPUTE_YES;
    }

    /**
     * Check if the return order is open
     *
     * @return bool
     */
    public function isOpen(): bool
    {
        return $this->status == self::STATUS_OPEN;
    }

    /**
     * Check if the return order is in progress
     *
     * @return bool
     */
    public function isInProgress(): bool
    {
        return $this->status == self::STATUS_IN_PROGRESS;
    }

    /**
     * Check if the return order is accepted
     *
     * @return bool
     */
    public function isAccepted(): bool
    {
        return $this->status == self::STATUS_ACCEPTED;
    }

    /**
     * Check if the return order is approved
     *
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->status == self::STATUS_APPROVED;
    }

    /**
     * Check if the return order is rejected
     *
     * @return bool
     */
    public function isRejected(): bool
    {
        return $this->status == self::STATUS_REJECTED;
    }
}
