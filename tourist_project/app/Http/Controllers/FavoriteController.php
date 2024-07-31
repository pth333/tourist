<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Tour;
use App\Traits\QueryCommonData;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    use QueryCommonData;
    public function listFavorite()
    {
        $commonData = $this->getCommonData();
        $favorites = Favorite::where('user_id', auth()->id())->paginate(5);
        return view('personal.favoriteTour', array_merge($commonData, compact('favorites')));
    }

    public function favoriteAdd(Request $request, $tourId)
    {
        $action = $request->input('action');
        $favoriteTour = Favorite::where('user_id', auth()->id())
            ->where('tour_id', $tourId)->first();

        if ($action == 'add' && !$favoriteTour) {
            Favorite::create([
                'user_id' => auth()->id(),
                'tour_id' => $tourId,
            ]);
            return response()->json([
                'code' => 200,
                'tourId' => $tourId,
                'action' => 'add',
            ], 200);
        } elseif ($action == 'remove' && !$favoriteTour) {
            return response()->json([
                'code' => 200,
                'tourId' => $tourId,
                'action' => 'remove',
            ], 200);
        } elseif ($action == 'remove' && $favoriteTour) {
            $favoriteTour->delete();
            return response()->json([
                'code' => 200,
                'tourId' => $tourId,
                'action' => 'remove',
            ], 200);
        }
    }

    public function deleteFavorite($tourId)
    {
        Favorite::where('user_id', auth()->id())
            ->where('tour_id', $tourId)
            ->delete();
        return response()->json([
            'code' => 200
        ], 200);
    }
}
