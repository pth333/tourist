<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];
    public function search($query){
        if(request()->key){
            $query = $query->where('name','like',"%$query%");
        }
        return $query;
    }
    use HasFactory;
}
