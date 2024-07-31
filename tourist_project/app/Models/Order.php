<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    protected $guarded = [];
    public function tour(){
        return $this->belongsTo(Tour::class, 'tour_id');
    }
    public function payment(){
        return $this->hasOne(Payment::class, 'p_order_id');
    }
    public function paymentmomo(){
        return $this->hasOne(PaymentMomo::class, 'order_id');
    }
    public function transaction(){
        return $this->hasOne(PaymentMomo::class, 'order_id');
    }
    use HasFactory, Notifiable;
}
