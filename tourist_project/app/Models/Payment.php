<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];
    public function order(){
        return $this->hasOne(Order::class, 'p_order_id');
    }
    use HasFactory;
}
