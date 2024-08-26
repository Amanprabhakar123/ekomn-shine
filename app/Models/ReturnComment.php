<?php

namespace App\Models;

use App\Models\User;
use App\Models\ReturnOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReturnComment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'return_id',
        'role_type',
        'comment',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'return_id' => 'integer',
        'role_type' => 'string',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    const ROLE_TYPE_BUYER = User::ROLE_BUYER;
    const ROLE_TYPE_SUPPLIER = User::ROLE_SUPPLIER;
    const ROLE_TYPE_ADMIN = User::ROLE_ADMIN;

    /**
     * Get the return that owns the ReturnComment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function return()
    {
        return $this->belongsTo(ReturnOrder::class, 'return_id', 'id');
    }
    
    /**
     * Get the user that owns the ReturnComment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function isBuyer()
    {
        return $this->role_type === self::ROLE_TYPE_BUYER;
    }

    /**
     * Get the user that owns the ReturnComment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function isSupplier()
    {
        return $this->role_type === self::ROLE_TYPE_SUPPLIER;
    }

    /**
     * Get the user that owns the ReturnComment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function isAdmin()
    {
        return $this->role_type === self::ROLE_TYPE_ADMIN;
    }
}
