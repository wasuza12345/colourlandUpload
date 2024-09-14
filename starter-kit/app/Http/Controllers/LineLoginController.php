<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LineLoginController extends Controller
{
    protected $clientId;
    protected $clientSecret;
    protected $redirectUri;

    public function __construct()
    {
        $this->clientId = env('LINE_CLIENT_ID');
        $this->clientSecret = env('LINE_CLIENT_SECRET');
        $this->redirectUri = env('LINE_REDIRECT_URI');
    }

    public function redirectToLine()
    {
        $state = bin2hex(random_bytes(16)); // สร้างค่า state เพื่อความปลอดภัย
        $nonce = bin2hex(random_bytes(16)); // ใช้ nonce เพื่อป้องกัน replay attacks

        $lineLoginUrl = "https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id={$this->clientId}&redirect_uri={$this->redirectUri}&state={$state}&scope=profile&nonce={$nonce}";

        return redirect($lineLoginUrl);
    }

    public function handleCallback(Request $request)
    {
        $code = $request->input('code');
        $state = $request->input('state');

        // แลกเปลี่ยน code กับ access token
        $response = Http::asForm()->post('https://api.line.me/oauth2/v2.1/token', [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $this->redirectUri,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
        ]);

        if ($response->failed()) {
            return redirect('/')->withErrors('Login with LINE failed');
        }

        $tokenData = $response->json();
        $accessToken = $tokenData['access_token'];

        // ดึงข้อมูล profile ของผู้ใช้
        $profileResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get('https://api.line.me/v2/profile');

        if ($profileResponse->failed()) {
            return redirect('/')->withErrors('Could not retrieve LINE profile');
        }

        $profileData = $profileResponse->json();

        // คุณสามารถใช้ข้อมูลโปรไฟล์เพื่อสร้างหรือล็อกอินผู้ใช้ในระบบของคุณได้ที่นี่
        $userId = $profileData['userId'];
        $displayName = $profileData['displayName'];
        $pictureUrl = $profileData['pictureUrl'];

        // บันทึกข้อมูลผู้ใช้ลงใน session
        session([
            'line_user_id' => $userId,
            'line_display_name' => $displayName,
            'line_picture_url' => $pictureUrl,
        ]);

        // หลังจากที่ดึงข้อมูลแล้ว คุณสามารถเปลี่ยนเส้นทางผู้ใช้ไปยังหน้า home หรือหน้าที่ต้องการได้
        return redirect('/register');
    }
}