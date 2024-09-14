<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FarmerWorkController extends Controller
{
    //
    public function index()
    {

        $data1 = DB::table("works")->orderBy('created_at', 'desc')->get();
        $data2 = DB::table('users')
            ->join('quantityProduct_for_farmer', 'quantityProduct_for_farmer.user_id', '=', 'users.id')
            ->where('users.status', 'farmer')
            ->get();

        // dd($data2);

        return view('content.pages.pages-work-farmer', compact('data1', 'data2'));
    }
    public function update_work_farmer(Request $request)
    {
        Log::info('Updating work farmer:', [
            'user_id' => $request->input('user_id'),
            'farmer_name' => $request->input('farmer_name'),
            'id_work' => $request->input('id_work'),
            'status' => $request->input('status')
        ]);

        // Update the work record
        DB::table('works')
            ->where('id', $request->input('id_work'))
            ->update([
                'farmer_name' => $request->input('farmer_name'),
                'farmer_id' => $request->input('user_id'),
                'status' => $request->input('status')
            ]);

        // Retrieve the user's LINE user ID
        $user = DB::table('users')->where('id', $request->input('user_id'))->first();

        // Check if user and line_user_id exist
        if ($user && $user->line_user_id) {
            Log::info('LINE User ID:', ['line_user_id' => $user->line_user_id]);

            // Call to send a LINE notification
            $this->sendLineNotification($user->line_user_id, "มีงานเข้า");
        } else {
            Log::error('Failed to find user or LINE user ID');
        }

        return response()->json(['message' => 'Work updated successfully!']);
    }

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
