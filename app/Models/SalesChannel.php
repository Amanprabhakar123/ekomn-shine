<?php

namespace App\Models;

use App\Models\ChannelProductMap;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesChannel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'is_active',
    ];

    /**
     * Get the channel product maps for the sales channel.
     */
    public function channelProductMaps()
    {
        return $this->hasMany(ChannelProductMap::class, 'sales_channel_id', 'id');
    }
}
