<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'category_image',
        'is_active',
        'meta_title',
        'meta_description',
        'parent_id',  // for depth level 3 parent_id store the sub category id that
        'depth',
        'root_parent_id'
    ];


    // Define the relationship with the parent category
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Define the relationship with the root parent category
    public function rootParent()
    {
        return $this->belongsTo(Category::class, 'root_parent_id');
    }
}
