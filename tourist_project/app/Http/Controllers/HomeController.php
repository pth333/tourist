<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Favorite;
use App\Models\Post;
use App\Models\Tour;
use App\Traits\QueryCommonData;


class HomeController extends Controller
{
    use QueryCommonData;
    public function index()
    {

        $commonData = $this->getCommonData();

        $destinations = Destination::take(4)->get();
        // dd($destinations);
        // tour ưu đãi
        $tours = Tour::whereRaw('sale_price != 0')->take(6)->latest()->get();

        $toursNewest = Tour::where('t_status', 0)->take(6)->latest()->get();

        $postsNewest = Post::take(6)->latest()->get();
        // dd($toursNewest);
        $lastIdOfPage = Destination::whereRaw('id % 4 = 0')->value('id');

        // dd($destinations[$lastIdOfPage-5]);

        $classPattern = ['col-lg-12 col-md-12', 'col-lg-6 col-md-12', 'col-lg-6 col-md-12'];
        $classCount = count($classPattern);
        foreach ($destinations as $index => $destination) {
            // $destination['delay'] = '0.' . rand(1, 7) . 's';
            $destination['col'] = $classPattern[$index % $classCount];
            $destinations[$index]['col'] = $destination['col'];
        }
        // dd($destinations);
        return view('home.home', array_merge($commonData, compact('lastIdOfPage', 'destinations','tours', 'toursNewest', 'postsNewest')));
    }
}
