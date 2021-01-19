<?php
/**
 * Created by PhpStorm.
 * User: wangyaqi
 * Date: 2020/01/02
 * Time: 00:24
 */

if (!function_exists('starMobile')) {
    /**
     * 手机号中间四位星号
     * @param $mobile string
     * @return string
     */
    function starMobile($mobile) : string
    {
        return substr_replace($mobile, '****', 3, 4);
    }
}

if (!function_exists('mobileReg')) {
    /**
     * 手机号验证正则
     * @return string
     */
    function mobileReg() : string
    {
        return '/^1[34578][0-9]{9}$/';
    }
}

if (!function_exists('passwordReg')) {
    /**
     * 密码验证正则
     * @return string
     */
    function passwordReg() : string
    {
        //大写、小写、数组、特殊字符各至少一个，8～16位
        return '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[$@!%*#?])[\S]{8,16}$/';
    }
}


if (!function_exists('emailReg')) {
    /**
     * 邮箱验证正则
     * @return string
     */
    function emailReg() : string
    {
        //大写、小写、数组、特殊字符各至少一个，8～16位
        return '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
    }
}

if (!function_exists('checkFlag')) {
    /**
     * 校验标记
     * @param $key string
     * @return bool | \Illuminate\Contracts\Cache\Repository
     */
    function checkFlag($key) : bool
    {
        try{
            //优先使用session
            if (request()->hasSession()) {
                $flag = session()->get($key);
            }else{
                $flag = cache()->get($key);
            }
            return (bool)$flag;
        }catch (\Exception $exception) {
            return false;
        }
    }
}

if (!function_exists('setFlag')) {
    /**
     * 设置标记
     * @param $key string
     * @param $value
     * @return bool
     */
    function setFlag($key, $value, $ttl = 600) : bool
    {
        try{
            //优先使用session
            if (request()->hasSession()) {
                session()->put($key, $value);
                return true;
            }else{
                return cache()->put($key, $value, $ttl);
            }
        }catch (\Exception $exception) {
            return false;
        }
    }
}

if (!function_exists('forgetFlag')) {
    /**
     * 清除标记
     * @param $key string
     * @param $value
     * @return bool
     */
    function forgetFlag($key) : bool
    {
        try{
            //优先使用session
            if (request()->hasSession()) {
                session()->forget($key);
                return true;
            }else{
                return cache()->forget($key);
            }
        }catch (\Exception $exception) {
            return false;
        }
    }
}

if (!function_exists('remove_hidden')) {
    /**
     * 取消Elequent的某些hidden属性
     * @param $attributtes array
     * @param $model \Illuminate\Database\Eloquent\Model
     * @return \Illuminate\Database\Eloquent\Model
     */
    function remove_hidden($model, $attributtes)
    {
        $hidden = $model->getHidden();
        $hidden = array_diff($hidden, $attributtes);

        $model->setHidden($hidden);

        return $model;
    }
}

//if (!function_exists('myselfNotice')) {
//    /**
//     * 如流hi机器人通知
//     * @param $message
//     * @param bool $return
//     * @return bool|mixed
//     */
//    function myselfNotice($message, $return = false)
//    {
//        $url = config('app.notice_webhook');
//        if (empty($url)) {
//            return false;
//        }
//
//        $client = new \GuzzleHttp\Client();
//        $response = $client->post($url, [
//            'json' => [
//                'message' => [
//                    'body' => [
//                        [
//                            'type' => 'TEXT',
//                            'content' => (string)$message
//                        ]
//                    ]
//                ]
//            ]
//        ])->getBody()->getContents();
//
//        if ($return) {
//            $data = json_decode($response, true);
//            return $data;
//        }
//    }
//}

if (!function_exists('myselfNotice')) {
    /**
     * 企业微信机器人通知
     * @param $message
     * @param bool $return
     * @return bool|mixed
     */
    function myselfNotice($message, $return = false)
    {
        $url = config('app.notice_webhook');
        if (empty($url)) {
            return false;
        }
        $client = new \GuzzleHttp\Client();
        $response = $client->post($url, [
            'json' => [
                'msgtype' => 'text',
                'text' => [
                    'content' => $message
                ]
            ]
        ])->getBody()->getContents();

        if ($return) {
            $data = json_decode($response, true);
            return $data;
        }
    }
}
