<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Tour extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function images(){
        return $this->hasMany(TourImage::class, 'tour_id');
    }

    public function tourSchedule(){
        return $this->hasMany(TourSchedule::class, 'tour_id');
    }


    public function scopeDeparture(Builder $q, $departure){
        $q->where('departure', 'like', "%{$departure}%");
    }
    public function scopeDestination(Builder $q, $destination){
        $q->where('destination', 'like', "%{$destination}%");
    }
    public function scopeDepartureDay(Builder $q, $departure_day){
        $q->where('departure_day', 'like', "%{$departure_day}%");
    }
    public function scopePrice(Builder $q, $price){
        $q->where('price', 'like', "%{$price}%");
    }
    public function scopeVehical(Builder $q, $type_vehical){
        $q->where('type_vehical', 'like', "%{$type_vehical}%");
    }
    public function scopeReturnday(Builder $q, $type_vehical){
        $q->where('type_vehical', 'like', "%{$type_vehical}%");
    }

}
