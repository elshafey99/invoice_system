<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class invoices extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'invoice_number',
        'invoice_Date',
        'due_date',
        'product',
        'section_id',
        'amount_collection',
        'amount_commission',
        'discount',
        'value_vat',
        'rate_vat',
        'total',
        'status',
        'value_status',
        'note',
        'Payment_date',
    ];
    protected $dates = ['deleted_at'];
    public function section(): BelongsTo
    {
        return $this->belongsTo(sections::class);
    }
}