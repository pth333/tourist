<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Tour;
use App\Models\User;

use App\Traits\QueryCommonData;


class ManagerInformationPersonnal extends Controller
{
    use QueryCommonData;
    public function showManager()
    {
        $commonData = $this->getCommonData();
        $orders = Order::where('user_id', auth()->id())->latest()->paginate(5);

        return view('personal.pageManager', array_merge($commonData, compact('orders')));
    }

    public function showProfile($id)
    {
        $commonData = $this->getCommonData();
        $userDetail = User::find($id);
        // dd($userDetail);
        return view('personal.pagePersonal', array_merge($commonData, compact('userDetail')));
    }
    public function deletePersonalTour($id)
    {
        Order::where('id', $id)->delete();
        return response()->json([
            'code' => 200,
        ], 200);
    }
}
