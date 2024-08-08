<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopCategory extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'priority'];

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
