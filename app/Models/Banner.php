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

    const BANNER_TYPE_HOME = 'home';
    const BANNER_TYPE_CATEGORY = 'category';
    const BANNER_TYPE_PRODUCT = 'product';
    const BANNER_TYPE_BRAND = 'user_dashboard';


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
}
