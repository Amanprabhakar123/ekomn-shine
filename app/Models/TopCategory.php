<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TopCategory extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['category_id', 'priority'];


     /**
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'category_id',
                'priority',
            ])
            ->logOnlyDirty()
            ->useLogName('Top Category Log')
            ->setDescriptionForEvent(fn (string $eventName) => "{$eventName} Top Category with ID: {$this->id}");
    }

    
    /**
     * Get the category that owns the TopCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * Get all of the topProduct for the TopCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function topProduct()
    {
        return $this->hasMany(TopProduct::class, 'category_id', 'id');
    }

}
