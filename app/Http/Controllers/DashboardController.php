<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $orderCount = DB::table("orders")->count();
        $cancelOrderCount = DB::table('orders')
            ->where(function ($query) {
                $query->where('status', 'cancelled')
                    ->orWhere('payment_status', 'rejected');
            })
            ->count();
        $totalFlowerQuantity = DB::table('quantityProduct_for_farmer')->sum('flower_quantity');
        $orderSuccess = DB::table('works')->where('status', 'completed')->count();
        $userlist = DB::table('users')->get();
        // dd($userlist);
        return view('content.pages.app-logistics-dashboard', compact('orderCount', 'cancelOrderCount', 'totalFlowerQuantity', 'orderSuccess', 'userlist'));
    }

    public function order_page()
    {
        $orderAll = DB::table('orders')->get();
        return view('content.pages.dashboard-order', compact('orderAll'));
    }

    public function quantity_page()
    {
        // เชื่อมโยงตาราง users, quantityProduct_for_farmer และ products จากนั้นกรองประเภทสินค้าเป็น "flower"
        $key_farmer = DB::table('users')
            ->where('status', 'farmer')
            ->join('quantityProduct_for_farmer', 'users.id', '=', 'quantityProduct_for_farmer.user_id')
            ->leftJoin('products', 'products.id', '=', 'quantityProduct_for_farmer.product_id')
            ->select('users.*', 'quantityProduct_for_farmer.*', 'products.name as product_name', 'products.image as imageProduct')
            // ->where('products.type', 'tray') // กรองประเภทสินค้าเป็น flower
            ->get();


        // ลบ dd ออกหากไม่ต้องการหยุดการทำงาน
        // dd($key_farmer);

        return view('content.pages.dashboard-quantity', compact('key_farmer'));
    }

    public function send_work_page()
    {
        return view('content.pages.dashboard-sendWork');
    }
}
