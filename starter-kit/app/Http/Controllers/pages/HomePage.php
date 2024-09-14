<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;

class HomePage extends Controller
{
  public function index()
  {
    try {
      $data = DB::table('orders')
        ->where('status', 'pending')
        ->orderBy('created_at', 'desc')
        ->get();

      $data1 = DB::table('orders')
        ->where('status', 'completed')
        ->whereIn('payment_status', ['pending', 'paid'])
        ->orderBy('created_at', 'desc')
        ->get();
      $data2 = DB::table('orders')
        ->where('status', 'completed')
        ->whereIn('payment_status', ['acceptOrder'])
        ->orderBy('created_at', 'desc')
        ->get();
      $data3 = DB::table('orders')
        ->where('status', 'completed')
        ->whereIn('payment_status', ['paidWork'])
        ->orderBy('created_at', 'desc')
        ->get();
      return view('content.pages.pages-home', ['key_orders' => $data, 'key_payment' => $data1, 'key_work' => $data2]);
    } catch (\Exception $e) {
      Log::error("Error fetching pending orders: " . $e->getMessage());
      return view('content.pages.pages-home', ['key_orders' => []]);
    }
  }
  // public function show_list_order($id_order)
  // {
  //   try {

  //     $fetch_orderlist = DB::table('order_lists')
  //       ->join('products', 'order_lists.product_id', '=', 'products.id')
  //       ->join('orders', 'order_lists.order_id', '=', 'orders.id')
  //       ->leftJoin('quantityProduct_for_farmer', function ($join) {
  //         $join->on('order_lists.product_id', '=', 'quantityProduct_for_farmer.product_id')
  //           ->whereRaw('quantityProduct_for_farmer.flower_quantity >= order_lists.quantity');
  //       })
  //       ->leftJoin('users', function ($join) {
  //         $join->on('users.id', '=', 'quantityProduct_for_farmer.user_id')
  //           ->where('users.status', '=', 'farmer');
  //       })
  //       ->where('order_lists.order_id', $id_order)
  //       ->whereRaw('orders.deadline <= quantityProduct_for_farmer.delivery_timeframe')
  //       ->select(
  //         'order_lists.*',
  //         'products.name as product_name',
  //         'products.image as product_image',
  //         'orders.deadline as order_deadline',
  //         'quantityProduct_for_farmer.flower_quantity as farmer_product_quantity',
  //         'quantityProduct_for_farmer.delivery_timeframe',
  //         'users.id as farmer_id',
  //         'users.name as farmer_name',
  //         'users.line_user_id as line_id'
  //       )
  //       ->get();
  //     return response()->json($fetch_orderlist);
  //   } catch (\Exception $e) {
  //     Log::error("Error list_order : " . $e->getMessage());
  //     return response()->json([
  //       'success' => false,
  //       'message' => $e->getMessage()
  //     ], 500);
  //   }
  // }
  public function show_list_order($id_order)
  {
    try {
      // ดึงข้อมูลจากฐานข้อมูล
      $fetch_orderlist = DB::table('order_lists')
        ->join('products', 'order_lists.product_id', '=', 'products.id')
        ->join('orders', 'order_lists.order_id', '=', 'orders.id')
        ->leftJoin('quantityProduct_for_farmer', function ($join) {
          $join->on('order_lists.product_id', '=', 'quantityProduct_for_farmer.product_id')
            ->whereRaw('quantityProduct_for_farmer.flower_quantity >= order_lists.quantity');
        })
        ->leftJoin('users', function ($join) {
          $join->on('users.id', '=', 'quantityProduct_for_farmer.user_id')
            ->where('users.status', '=', 'farmer');
        })
        ->where('order_lists.order_id', $id_order)
        ->whereRaw('orders.deadline <= quantityProduct_for_farmer.delivery_timeframe')
        ->select(
          'order_lists.id as order_list_id',
          'order_lists.order_id',
          'order_lists.product_id',
          'order_lists.quantity',
          'order_lists.price',
          'products.name as product_name',
          'products.image as product_image',
          'products.type as product_type',
          'orders.deadline as order_deadline',
          'quantityProduct_for_farmer.flower_quantity as farmer_product_quantity',
          'quantityProduct_for_farmer.delivery_timeframe',
          'users.id as farmer_id',
          'users.name as farmer_name',
          'users.line_user_id as line_id'
        )
        ->get();

      // จัดกลุ่มข้อมูลและรวมข้อมูลของเกษตรกร
      $order_data = [];
      foreach ($fetch_orderlist as $order) {
        $order_list_id = $order->order_list_id;

        // ถ้ายังไม่มีข้อมูลใน array นี้ ให้สร้างใหม่
        if (!isset($order_data[$order_list_id])) {
          $order_data[$order_list_id] = [
            'order_list_id' => $order->order_list_id,  // เพิ่ม order_list_id เข้าไปด้วย
            'order_id' => $order->order_id,
            'product_id' => $order->product_id,
            'product_name' => $order->product_name,
            'product_image' => $order->product_image,
            'product_type' => $order->product_type,
            'order_deadline' => $order->order_deadline,
            'quantity' => $order->quantity,
            'price' => $order->price,
            'farmer_product_quantity' => $order->farmer_product_quantity,
            'data_farmer' => []
          ];
        }

        // เพิ่มข้อมูลของเกษตรกรลงใน array
        $order_data[$order_list_id]['data_farmer'][] = [
          'farmer_id' => $order->farmer_id,
          'farmer_name' => $order->farmer_name,
          'line_id' => $order->line_id
        ];
      }

      // เปลี่ยนแปลงรูปแบบผลลัพธ์ให้เป็น array ของ object
      $order_data = array_values($order_data);

      // ส่งผลลัพธ์กลับเป็น JSON
      return response()->json($order_data);
    } catch (\Exception $e) {
      Log::error("Error list_order : " . $e->getMessage());
      return response()->json([
        'success' => false,
        'message' => $e->getMessage()
      ], 500);
    }
  }
  public function show_list_order1($id_order)
  {
    try {
      $fetch_orderlist = DB::table('order_lists')
        ->join('products', 'order_lists.product_id', '=', 'products.id')
        ->where('order_lists.order_id', $id_order)
        ->get(['products.*', 'order_lists.*']); // Corrected: Specify the columns correctly

      return response()->json($fetch_orderlist);
    } catch (\Exception $e) {
      Log::error("Error list_order : " . $e->getMessage());
      return response()->json([
        'success' => false,
        'message' => $e->getMessage()
      ], 500);
    }
  }
  public function show_cancel_order()
  {
    try {
      $cancel_order = DB::table('orders')
        ->where(function ($query) {
          $query->where('status', 'cancelled')
            ->orWhere('payment_status', 'rejected');
        })
        ->get();

      return view('content.pages.pages-cancel', compact('cancel_order'));
    } catch (\Exception $e) {
      Log::error("Error list_order : " . $e->getMessage());
      return response()->json([
        'success' => false,
        'message' => $e->getMessage()
      ], 500);
    }
  }

  public function assignWorks(Request $request)
  {
    $worksData = $request->json()->all();
    Log::info('Received data:', $worksData);

    DB::beginTransaction();
    try {
      foreach ($worksData as $workData) {
        Log::info('Inserting work data:', $workData);
        $insertResult = DB::table('works')->insert([
          'farmer_id' => $workData['farmer_id'],
          'order_id' => $workData['order_id'],
          'status' => $workData['status'],
          'quantity' => $workData['quantity'],
          'order_deadline' => $workData['order_deadline'],
          'orderlist_id' => $workData['id'],
          'product_id' => $workData['product_id'],
          'product_name' => $workData['product_name'],
          'product_image' => $workData['product_image'],
          'farmer_name' => $workData['farmer_name'],
          'created_at' => now(),
          'updated_at' => now()
        ]);
        Log::info('Insert result:', ['success' => $insertResult]);

        // ส่งการแจ้งเตือนผ่าน LINE สำหรับงานแต่ละรายการ
        // $test = 'Uc97970b12438344ef93d3bf3528d91b9';
        // $workData['line_id'];
        $this->sendLineNotification($workData['line_id'], "มีงานเข้าดอก {$workData['product_name']} จำนวน {$workData['quantity']} ดอก", $workData['product_image']);
      }

      DB::commit();


      return response()->json(['message' => 'Works assigned successfully'], 200);
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error('Error assigning works: ' . $e->getMessage(), ['exception' => $e]);
      return response()->json(['message' => 'Error assigning works: ' . $e->getMessage()], 500);
    }
  }

  // public function assignWorks(Request $request)
  // {
  //   $worksData = $request->json()->all();
  //   Log::info('Received data:', $worksData);

  //   DB::beginTransaction();
  //   try {
  //     foreach ($worksData as $workData) {
  //       Log::info('Inserting work data:', $workData);
  //       $insertResult = DB::table('works')->insert([
  //         'farmer_id' => $workData['farmer_id'],
  //         'order_id' => $workData['order_id'],
  //         'status' => $workData['status'],
  //         'quantity' => $workData['quantity'],
  //         'order_deadline' => $workData['order_deadline'],
  //         'orderlist_id' => $workData['id'],
  //         'product_id' => $workData['product_id'],
  //         'product_name' => $workData['product_name'],
  //         'product_image' => $workData['product_image'],
  //         'farmer_name' => $workData['farmer_name'],
  //         'created_at' => now(),
  //         'updated_at' => now()
  //       ]);
  //       Log::info('Insert result:', ['success' => $insertResult]);
  //     }

  //     DB::commit();

  //     Log::info($workData['line_id']);
  //     $this->sendLineNotification($workData['line_id'], "มีงานเข้าดอก{$workData['product_name']} {$workData['quantity']} ดอก", $workData['product_image']);
  //     return response()->json(['message' => 'Works assigned successfully'], 200);
  //   } catch (\Exception $e) {
  //     DB::rollBack();
  //     Log::error('Error assigning works: ' . $e->getMessage(), ['exception' => $e]);
  //     return response()->json(['message' => 'Error assigning works: ' . $e->getMessage()], 500);
  //   }
  // }


  public function updateOrderStatus($orderId, $action)
  {
    try {
      $order = DB::table('orders')->where('id', $orderId)->first();
      if (!$order) {
        return response()->json([
          'success' => false,
          'message' => "Order #{$orderId} not found."
        ], 404);
      }

      $newStatus = '';
      switch ($action) {
        case 'complete':
          $newStatus = 'completed';
          break;
        case 'cancel':
          $newStatus = 'cancelled';
          break;
        default:
          return response()->json([
            'success' => false,
            'message' => "Invalid action."
          ], 400);
      }

      $affected = DB::table('orders')
        ->where('id', $orderId)
        ->update(['status' => $newStatus]);

      if ($affected) {
        Log::info("Order #{$orderId} has been {$action}ed.");

        // ดึง LINE User ID
        $lineUserId = DB::table('orders')
          ->join('users', 'orders.user_id', '=', 'users.id')
          ->where('orders.id', $orderId)
          ->value('users.line_user_id');

        if ($lineUserId) {
          $this->sendLineNotification($lineUserId, "ออเดอร์ #{$orderId} ของคุณได้รับการอัพเดทสถานะเป็น {$newStatus} แล้วค่ะ");
        }

        return response()->json([
          'success' => true,
          'message' => "Order #{$orderId} has been {$action}ed successfully."
        ]);
      } else {
        return response()->json([
          'success' => false,
          'message' => "Failed to {$action} order #{$orderId}."
        ], 500);
      }
    } catch (\Exception $e) {
      Log::error("Error {$action}ing order #{$orderId}: " . $e->getMessage());
      return response()->json([
        'success' => false,
        'message' => "An error occurred while {$action}ing the order: " . $e->getMessage()
      ], 500);
    }
  }
  public function updatePaymentStatus(Request $request)
  {
    try {
      $orderId = $request->input('order_id');
      $newPaymentStatus = $request->input('payment_status');

      // ตรวจสอบความถูกต้องของข้อมูล
      if (!$orderId || !$newPaymentStatus) {
        throw new \Exception('Invalid input data');
      }

      // อัปเดตสถานะในฐานข้อมูล
      $updated = DB::table('orders')
        ->where('id', $orderId)
        ->update(['payment_status' => $newPaymentStatus]);

      if (!$updated) {
        throw new \Exception('Failed to update order status');
      }

      // ดึง LINE User ID
      $lineUserId = DB::table('orders')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->where('orders.id', $orderId)
        ->value('users.line_user_id');

      if ($lineUserId) {
        $this->sendLineNotification($lineUserId, "ออเดอร์ #{$orderId} ของคุณได้รับการอัพเดทสถานะเป็น {$newPaymentStatus} แล้วค่ะ");
      }

      Log::info("Order #{$orderId} payment status has been updated to {$newPaymentStatus}.");

      return response()->json([
        'success' => true,
        'message' => "Order #{$orderId} payment status has been updated to {$newPaymentStatus} successfully."
      ]);
    } catch (\Exception $e) {
      Log::error("Error updating payment status for Order  #{$newPaymentStatus} #{$orderId}: " . $e->getMessage());
      return response()->json([
        'success' => false,
        'message' => "An error occurred: " . $e->getMessage()
      ], 500);
    }
  }

  // private function sendLineNotification($userId, $message)
  // {
  //   $accessToken = env('LINE_CHANNEL_ACCESS_TOKEN');
  //   // $thaiStatus = $this->getThaiStatus($status);
  //   // $message = "ออเดอร์ #{$orderId} ของคุณได้รับการอัพเดทสถานะเป็น {$status} แล้วค่ะ";

  //   $data = [
  //     'to' => $userId,
  //     'messages' => [
  //       [
  //         'type' => 'text',
  //         'text' => $message
  //       ]
  //     ]
  //   ];

  //   $headers = [
  //     'Content-Type: application/json',
  //     'Authorization: Bearer ' . $accessToken
  //   ];

  //   $ch = curl_init('https://api.line.me/v2/bot/message/push');
  //   curl_setopt($ch, CURLOPT_POST, true);
  //   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
  //   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  //   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  //   $result = curl_exec($ch);
  //   $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

  //   if ($httpCode !== 200) {
  //     Log::error("Failed to send LINE notification. HTTP Code: " . $httpCode . ", Response: " . $result);
  //   }

  //   curl_close($ch);
  // }
  // private function sendLineNotification($userId, $message, $imageUrl = null)
  // {
  //   $accessToken = env('LINE_CHANNEL_ACCESS_TOKEN');

  //   $messages = [
  //     [
  //       'type' => 'text',
  //       'text' => $message
  //     ]
  //   ];

  //   // ถ้ามี URL รูปภาพ ให้เพิ่มข้อความรูปภาพ
  //   if ($imageUrl) {
  //     $messages[] = [
  //       'type' => 'image',
  //       'originalContentUrl' => $imageUrl,
  //       'previewImageUrl' => $imageUrl // คุณอาจต้องการใช้ URL ที่แตกต่างสำหรับภาพตัวอย่าง
  //     ];
  //   }

  //   $data = [
  //     'to' => $userId,
  //     'messages' => $messages
  //   ];

  //   $headers = [
  //     'Content-Type: application/json',
  //     'Authorization: Bearer ' . $accessToken
  //   ];

  //   $ch = curl_init('https://api.line.me/v2/bot/message/push');
  //   curl_setopt($ch, CURLOPT_POST, true);
  //   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
  //   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  //   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  //   $result = curl_exec($ch);
  //   $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

  //   if ($httpCode !== 200) {
  //     Log::error("Failed to send LINE notification. HTTP Code: " . $httpCode . ", Response: " . $result);
  //   }

  //   curl_close($ch);
  // }
  private function sendLineNotification($userId, $message, $imageUrl = null)
  {
    $accessToken = env('LINE_CHANNEL_ACCESS_TOKEN');

    $messages = [];

    // Add the image message first if an image URL is provided
    if ($imageUrl) {
      $messages[] = [
        'type' => 'image',
        'originalContentUrl' => $imageUrl,
        'previewImageUrl' => $imageUrl // Consider using a different URL for the preview if necessary
      ];
    }

    // Add the text message next
    $messages[] = [
      'type' => 'text',
      'text' => $message
    ];

    $data = [
      'to' => $userId,
      'messages' => $messages
    ];

    $headers = [
      'Content-Type: application/json',
      'Authorization: Bearer ' . $accessToken
    ];

    $ch = curl_init('https://api.line.me/v2/bot/message/push');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpCode !== 200) {
      Log::error("Failed to send LINE notification. HTTP Code: " . $httpCode . ", Response: " . $result);
    } else {
      Log::info("LINE notification sent successfully to: " . $userId);
    }

    curl_close($ch);
  }
}
