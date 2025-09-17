<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'product_id',
        'channel_id',
        'payment_id',
        'admin_id',
        'price',
        'link',
        'date',
        'ship_date',
        'note',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'date' => 'date',
        'ship_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
