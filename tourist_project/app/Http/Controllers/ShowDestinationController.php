<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use App\Traits\QueryCommonData;

class ShowDestinationController extends Controller
{
    use QueryCommonData;

    public function listAllDestination(Request $request)
    {
        $commonData = $this->getCommonData();

        $destinationList = Destination::latest()->paginate(8);
        $destinations = Destination::whereRaw('category_id !=0')->select('category_id')->distinct()->get();
        $ticketPrice = Destination::select('ticket_price')->distinct()->get();

        $categoryItems = [];
        foreach ($destinations as $destination) {
            $categoryDistincts = $destination->category;
            array_push($categoryItems, $categoryDistincts);
        }

        return view('show.destination.showList', array_merge($commonData, compact('destinationList', 'ticketPrice', 'categoryItems')));
    }

    public function showDetailDestination($id, $slug)
    {
        $commonData = $this->getCommonData();
        $destinationDetail = Destination::where('id', $id)->first();
        $views_count = $destinationDetail->views_count + 1;
        $destinationDetail->update([
            'views_count' => $views_count
        ]);
        // dd($views_count);
        $destinationNew = Destination::latest()->take(9)->get();
        return view('show.destination.showDetail', array_merge($commonData, compact('destinationDetail', 'destinationNew','views_count')));
    }
}
