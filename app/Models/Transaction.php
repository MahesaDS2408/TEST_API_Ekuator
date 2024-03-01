<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'product_id',
        'price',
        'quantity',
        'admin_fee',
        'tax',
        'total',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'product_id' => 'integer',
        'price' => 'integer',
        'quantity' => 'integer',
        'admin_fee' => 'integer',
        'tax' => 'integer',
        'total' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
