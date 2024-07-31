<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;
use App\Traits\QueryCommonData;
use Illuminate\Support\Facades\DB;

class ShowTourController extends Controller
{
    use QueryCommonData;
    public function listAllTour()
    {
        $commonData = $this->getCommonData();
        $tourList = Tour::latest()->paginate(9);
        $uniquePrice = Tour::select('price')->distinct()->get();
        $uniqueVehical = Tour::select('type_vehical')->distinct()->get();
        $uniqueNumberOfDay = Tour::select(DB::raw('DISTINCT DATEDIFF(return_day,departure_day) as number_days'))
                                ->get();
        return view('show.tour.showList', array_merge($commonData,compact('tourList','uniquePrice','uniqueVehical','uniqueNumberOfDay')));
    }
    public function showDetailTour($id){
        $commonData = $this->getCommonData();
        // Lấy ra tour chi tiết
        $tourDetail = Tour::where('id', $id)->first();
        // Tour lieen quan
        $relatedTours = Tour::where('departure', $tourDetail->departure)
                                ->orWhere('destination', $tourDetail->destination)
                                ->orderBy('id')
                                ->limit(3)
                                ->get();

        // lịch trình chi tiêt
        $scheduleDetail = $tourDetail->tourSchedule()->get();
        // dd($scheduleDetail);
        return view('show.tour.showDetail',array_merge($commonData,compact('tourDetail','scheduleDetail','relatedTours')));
    }
}
