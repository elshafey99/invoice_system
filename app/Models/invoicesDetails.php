<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoicesDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_invoice',
        'invoice_number',
        'product',
        'section',
        'Status',
        'value_status',
        'note',
        'user',
        'payment_date',
    ];
}
