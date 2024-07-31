<?php

namespace App\Traits;

use App\Models\Slider;
use App\Models\Category;
use App\Models\Setting;
use App\Models\Comment;

trait QueryCommonData
{
    public function getCommonData(){
        $fileImage = 'http://127.0.0.1:8000';
        $categories = Category::where('parent_id', 0)->get();
        $sliders = Slider::latest()->first();
        $settings = Setting::all();
        $comments = Comment::take(6)->get();
        return compact('fileImage','categories','sliders','settings','comments');
    }
}
