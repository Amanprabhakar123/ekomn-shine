<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'title',
        'image_path',
        'banner_type',
        'category_id',
        'user_role',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    const BANNER_TYPE_HOME = '1';
    const BANNER_TYPE_CATEGORY = '2';
    const BANNER_TYPE_PRODUCT = '3';
    const BANNER_TYPE_USER = '4';

    const BANNER_TYPE_ARRAY = [
        self::BANNER_TYPE_HOME => 'Home',
        self::BANNER_TYPE_CATEGORY => 'Category',
        self::BANNER_TYPE_PRODUCT => 'Product',
        self::BANNER_TYPE_USER => 'User Dashboard',
    ];  


    /**
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'title',
                'image_path',
                'banner_type',
                'category_id',
                'user_role',
            ])
            ->logOnlyDirty()
            ->useLogName('Banner Log')
            ->setDescriptionForEvent(fn (string $eventName) => "{$eventName} banner with ID: {$this->id}");
    }


    /**
     * Get the category that owns the banner.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * Get the user that owns the banner.
     */
    public function getType()
    {
        return self::BANNER_TYPE_ARRAY[$this->banner_type];
    }
}
