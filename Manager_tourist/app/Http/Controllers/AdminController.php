<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Tour;
use App\Models\Post;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $tours = Tour::count();
        $orders = Order::count();
        $posts = Post::count();
        $users = User::count();
        $orderCus = Order::select('user_id')->distinct()->get();
        // Tổng số khách hàng
        $customers = [];
        foreach ($orderCus as $cus) {
            $customerOrder = $cus->user;
            array_push($customers, $customerOrder);
        }
        $amountCustomer = count($customers);

        $today = Carbon::now()->toDateString();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        // Truy vấn doanh thu theo ngày

        $dailyRevenue = Order::whereDate('created_at', $today)
            ->sum('total_price');

        $monthlyRevenue = Order::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('total_price');

        $yearlyRevenue = Order::whereYear('created_at', $currentYear)
            ->sum('total_price');


        $status_default = Tour::where('t_status', 0)->count();
        $status_process = Tour::where('t_status', 1)->count();
        $status_end = Tour::where('t_status', 2)->count();

        $statusAll = [$status_default,$status_process,$status_end];

        // dd($statusAll);

        // Lấy dữ liệu từ database
        $revenues = Order::select(
            DB::raw('MONTH(orders.created_at) as month'),
            'categories.name as category_name',
            DB::raw('SUM(orders.total_price) as total_revenue')
        )
            ->join('tours', 'orders.tour_id', '=', 'tours.id')
            ->join('categories', 'tours.category_id', '=', 'categories.id')
            ->whereYear('orders.created_at', $currentYear)
            ->groupBy('month', 'category_name')
            ->orderBy('month')
            ->get();

        // Chuẩn bị dữ liệu cho biểu đồ
        $months = range(1, 12);
        $datasets = [];
        $categories = $revenues->groupBy('category_name');

        foreach ($categories as $category => $data) {
            $monthlyData = array_fill(0, 12, 0);
            foreach ($data as $record) {
                // dd($record);
                $monthlyData[$record->month - 1] = $record->total_revenue;
            }

            $datasets[] = [
                'label' => $category,
                'data' => array_values($monthlyData),
                'backgroundColor' => $this->randomColor(),
                'borderColor' => $this->randomColor(),
                'borderWidth' => 1,
                'fill' => false
            ];
        }

        $dataAll = [
            'tours' => $tours,
            'orders' => $orders,
            'posts' => $posts,
            'users' => $users,
            'customers' => $amountCustomer,
            'dailyRevenue' => $dailyRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'yearlyRevenue' => $yearlyRevenue,
            'months' => $months,
            'datasets' => $datasets,

        ];

        $months =  array_map(fn ($month) => "Tháng $month", $months);
        // dd($datasets);

        return view('dashboard', compact('dataAll', 'statusAll'));
    }
    private function randomColor()
    {
        return '#' . substr(md5(rand()), 0, 6);
    }
}
