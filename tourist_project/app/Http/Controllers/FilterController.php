<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use App\Models\Tour;
use App\Traits\QueryCommonData;

class FilterController extends Controller
{
    use QueryCommonData;
    public function filterTour(Request $request)
    {
        $commonData = $this->getCommonData();
        $query = Tour::query();

        // dd($query->price($request->price_range)->get());
        if ($request->price_range) {
            $query->price($request->price_range);
        }

        if ($request->type_vehical) {
            $query->vehical($request->type_vehical);
        }

        if ($request->departure_day) {
            $query->departureday($request->input('departure_day'));
        }

        if ($request->return_day) {
            $query->returnday($request->input('return_day'));
        }

        $resultFilters = $query->orderBy('id')->paginate(6);
        // dd($resultFilters);

        return view('show.filter.filterTour', array_merge($commonData, compact('resultFilters')));
    }

    public function filterDestination(Request $request)
    {
        $commonData = $this->getCommonData();
        // dd($request->price_range);
        $query = Destination::query();
        if ($request->ticket_price) {
            $query->price($request->ticket_price);
        }
        if ($request->category) {
            $query->typedestination($request->category);
        }

        $resultFilters = $query->orderBy('id')->paginate(8);
        // dd($resultFilters);

        return view('show.filter.filterDestination', array_merge($commonData, compact('resultFilters')));
    }
}
