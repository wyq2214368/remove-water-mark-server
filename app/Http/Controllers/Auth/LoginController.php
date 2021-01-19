<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $miniProgram = \EasyWeChat::miniProgram(); // 小程序
        $sessionInfo = $miniProgram->auth->session($request->input('code'));
        $decryptedData = $miniProgram->encryptor->decryptData($sessionInfo['session_key'], $request->input('iv'), $request->input('data'));
        $user = User::firstOrCreate([
            'openid' => $decryptedData['openId'],
        ],[
            'name' => $this->filterEmoji($decryptedData['nickName']),
            'avatar' => $decryptedData['avatarUrl'],
            'gender' => $decryptedData['gender'],
            'unionid' => $decryptedData['unionId'],
            'country' => $decryptedData['country'],
            'province' => $decryptedData['province'],
            'city' => $decryptedData['city'],
        ]);

        $user->api_token = Str::random(80);
        $user->save();

        return response()->json(['token' => $user->api_token]);
    }

    // 过滤掉emoji表情
    private function filterEmoji($str)
    {
        $str = preg_replace_callback(    //执行一个正则表达式搜索并且使用一个回调进行替换
            '/./u',
            function (array $match) {
                return strlen($match[0]) >= 4 ? '' : $match[0];
            },
            $str);

        return $str;
    }

}
