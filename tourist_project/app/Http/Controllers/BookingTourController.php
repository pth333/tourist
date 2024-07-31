<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Tour;
use Illuminate\Http\Request;
use App\Traits\QueryCommonData;
use Illuminate\Support\Facades\Validator;

class BookingTourController extends Controller
{
    use QueryCommonData;
    public function formBookingTour($id, $slug)
    {
        $commonData = $this->getCommonData();
        $tourId = $id;
        $tour = Tour::find($id);
        // dd($tour);
        return view('show.booking.pageBooking', array_merge($commonData), compact('tourId', 'tour'));
    }
    public function bookingTour(Request $request, $id)
    {
        $tour = Tour::find($request->tourId);
        // lấy ra session của customer
        // dd($tour);
        $data = session()->get('customer');

        $totalPrice = $request->totalPrice;
        // dd($tour);
        $totalDeposit = $request->totalDeposit;
        $totalPerson = $request->quantity_adult + $request->quantity_child + $request->quantity_infant;
        $totalParticipants = $tour->participants + $totalPerson;

        if ($request->paymentType == 1) {
            // Lấy ra thêm total_price khi thanh toán
            $data['customer'] = [
                'user_id' => auth()->id(),
                'tour_id' => $request->tourId,
                'email' => $request->email,
                'phone' => $request->phone,
                'total_price' => $totalPrice,
                'total_deposit' => 0,
                'total_adult' => $request->quantity_adult,
                'total_child' => $request->quantity_child,
                'total_infant' => $request->quantity_infant,
                'total_person' => $totalPerson,
                'participants' => $totalParticipants,
                'status' => 1
            ];
            session()->put('customer', $data);
        } else {
            // Lấy ra thêm total_deposit khi đặt cọc
            $data['customer'] = ['total_deposit' => $totalDeposit];
            $data['customer'] = [
                'user_id' => auth()->id(),
                'tour_id' => $request->tourId,
                'email' => $request->email,
                'phone' => $request->phone,
                'total_price' => 0,
                'total_adult' => $request->quantity_adult,
                'total_child' => $request->quantity_child,
                'total_infant' => $request->quantity_infant,
                'total_deposit' => $totalDeposit,
                'total_person' => $totalPerson,
                'participants' => $totalParticipants,
                'status' => 2
            ];
            session()->put('customer', $data);
        }

        $orderCustomer = session()->get('customer');
        // dd($orderCustomer);
        $bookingComponent = view('payment.payment', compact('orderCustomer'))->render();

        return response()->json([
            'code' => 200,
            'bookingComponent' => $bookingComponent
        ], 200);
    }

    public function paymentDeposit($orderId)
    {
        $orderDeposit = Order::find($orderId);
        $total_price = $orderDeposit->total_deposit;
        $total_person = $orderDeposit->total_adult + $orderDeposit->total_child + $orderDeposit->total_infant;
        $dataAll = [
            'total_price' => $total_price,
            'total_person' => $total_person,
            'orderId' => $orderId,
        ];
        // dd($dataAll);
        return view('payment.payment_deposit', compact('dataAll'));
    }
}
