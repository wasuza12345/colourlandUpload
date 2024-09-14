<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FarmerWorkController;
use App\Http\Controllers\FlowerController;
use App\Http\Controllers\LineLoginController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

// Route สำหรับการ Logout



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', [HomePage::class, 'index'])->name('pages-home');
    Route::get('/data', [HomePage::class, 'status_payment_status']);
    Route::post('/orders/{orderId}/{action}', [HomePage::class, 'updateOrderStatus']);
    Route::post('/orders/update-payment-status', [HomePage::class, 'updatePaymentStatus']);
    Route::get('/show_orderlist/{id_order}', [HomePage::class, 'show_list_order']);
    Route::post('/assign_works', [HomePage::class, 'assignWorks']);
    Route::get('/show_orderlist_model1/{id_order}', [HomePage::class, 'show_list_order1']);
    //Products
    Route::get('/productAdmin', [FlowerController::class, 'index'])->name('product-admin');
    Route::post('/add_productAdmin', [FlowerController::class, 'store'])->name('flowers.store');
    Route::get('/product/delete/{id}', [FlowerController::class, 'delete']);
    //cancel all
    Route::get('/show_order_cencel', [Homepage::class, 'show_cancel_order'])->name('cancel-page');
    //dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/order', [DashboardController::class, 'order_page'])->name('dashboard');
    Route::get('/dashboard/quantity', [DashboardController::class, 'quantity_page'])->name('dashboard');
    Route::get('/dashboard/sendWork', [DashboardController::class, 'send_work_page'])->name('dashboard');
    Route::get('/work_farmer', [FarmerWorkController::class, 'index'])->name('work-of-farmer');
    Route::post('/update_work_farmer', [FarmerWorkController::class, 'update_work_farmer']);
});
// Route สำหรับการเริ่มต้นการล็อกอินผ่าน LINE
Route::get('/line/login', [LineLoginController::class, 'redirectToLine']);

// Route สำหรับรับ callback หลังจากผู้ใช้ล็อกอินผ่าน LINE
Route::get('/callback', [LineLoginController::class, 'handleCallback'])->name('line.callback');
// Route::get('/logout', function () {
//     session()->flush(); // ล้างข้อมูล session
//     return redirect('/login');
// })->name('logout');
// Route สำหรับหน้า Home ที่แสดงข้อมูลผู้ใช้
Route::get('/home', function () {
    // ตรวจสอบว่าผู้ใช้ได้ล็อกอินแล้วหรือยัง
    if (!session('line_user_id')) {
        return redirect('/login');
    }


    return view('home');
})->name('home');
