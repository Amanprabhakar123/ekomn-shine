<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportErrorMessage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'import_id',
        'row_number',
        'field_name',
        'error_message',
    ];

    /**
     * Get the import associated with the error message.
     */
    public function import()
    {
        return $this->belongsTo(Import::class, 'import_id', 'id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'import_id' => 'integer',
    ];
}
