<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class products extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'section_id',
        'description'
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(sections::class);
    }
}
