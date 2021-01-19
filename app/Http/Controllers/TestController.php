<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TestController extends Controller
{
    public function index($action)
    {
        abort_if(app()->environment('production'), Response::HTTP_FORBIDDEN);
        return $this->$action();
    }

    protected function http()
    {
        dd(request()->headers);
    }

    protected function mpPageSearch()
    {
        $miniProgram = \EasyWeChat::miniProgram(); // 小程序
        $accessTokenService = $miniProgram->access_token;
        $accessToken = $accessTokenService->getToken();
        $client = new Client();
        $response = $client->post('https://api.weixin.qq.com/wxa/search/wxaapi_submitpages', [
            'query' => [
                'access_token' => $accessToken
            ],
            'form_params' => [
                'pages' => [
                    [
                        'path' => 'pages/index/index',
                        'query' => ''
                    ],
                    [
                        'path' => 'pages/mine/indexs',
                        'query' => ''
                    ],
                ]
            ]
        ])->getBody()->getContents();
        return $response;
    }
}
