<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLoginHistory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'last_login',

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'last_login' => 'datetime',
    ];

    /**
     * Get the user associated with the login history.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the company detail associated with the login history.
     */
    public function companyDetail()
    {
        return $this->belongsTo(CompanyDetail::class, 'user_id', 'user_id');
    }
}
