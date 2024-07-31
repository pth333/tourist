<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Tour;
use Illuminate\Http\Request;
use App\Traits\QueryCommonData;

class SearchTourController extends Controller
{
    use QueryCommonData;
    public function searchTour(Request $request)
    {

        $commonData = $this->getCommonData();
        $query = Tour::query();

        if ($request->input('departure')) {
            $query->departure($request->input('departure'));
        }

        if ($request->input('destination')) {
            $query->destination($request->input('destination'));
        }

        if ($request->input('date')) {
            $query->departureday($request->input('date'));
        }

        $resultSearch = $query->orderBy('id')->paginate(6);
        // dd($resultSearch);
        return view('show.search.resultTour', array_merge($commonData, compact('resultSearch')));
    }

    public function searchLocation(Request $request)
    {
        $commonData = $this->getCommonData();
        $query = Destination::query();

        if ($request->input('location')) {
            $query->location($request->input('location'));
        }

        $resultSearch = $query->first();
        // dd($resultSearch);
        return view('show.search.resultLocation', array_merge($commonData, compact('resultSearch')));
    }

    public function searchAjaxDeparture(Request $request)
    {
        $departures = Tour::select('departure')
            ->where('departure', 'like', "%{$request->departure}%")
            ->distinct()
            ->limit(5)
            ->pluck('departure');
        // dd($departures);
        return view('show.search.destination.searchDeparture', compact('departures'));
    }

    public function searchAjaxDestination(Request $request)
    {
        $destinations = Tour::select('destination')
            ->where('destination', 'like', "%{$request->destination}%")
            ->distinct()
            ->limit(5)
            ->pluck('destination');
        // return response()->json($departures);
        return view('show.search.destination.searchDestination', compact('destinations'));
    }

    public function searchAjaxLocation(Request $request)
    {
        $locations = Destination::select('name_des')
            ->where('name_des', 'like', "%{$request->location}%")
            ->distinct()
            ->limit(5)
            ->pluck('name_des');
        // return response()->json($departures);
        return view('show.search.destination.searchLocation', compact('locations'));
    }
}
