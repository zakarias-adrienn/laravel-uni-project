<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['address', 'comment', 'payment_method', 'status', 'processed_on', 'received_on'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ordered_items() // ezt így kell? kisbetűvel
    {
        return $this->hasMany(OrderedItem::class);
    }
}
