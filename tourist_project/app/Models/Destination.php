<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Destination extends Model
{
    protected $guarded = [];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function images()
    {
        return $this->hasMany(DestinationImage::class, 'destination_id');
    }

    public function detail(){
        return $this->hasOne(DestinationDetail::class, 'des_id');
    }

    public function foods(){
        return $this->hasMany(DestinationFoodDetail::class, 'des_id');
    }

    public function scopeDeparture(Builder $q, $departure)
    {
        $q->where('departure', 'like', "%{$departure}%");
    }
    public function scopeDestination(Builder $q, $destination)
    {
        $q->where('destination', 'like', "%{$destination}%");
    }
    public function scopePrice(Builder $q, $price)
    {
        $q->where('ticket_price', 'like', "%{$price}%");
    }
    public function scopeTypeDestination(Builder $q, $category_id)
    {
        $q->where('category_id', 'like', "%{$category_id}%");
    }
    public function scopelocation(Builder $q, $location)
    {
        $q->where('name_des', 'like', "%{$location}%");
    }
    use HasFactory;
}
