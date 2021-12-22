<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Services\VideoPareseService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use QL\QueryList;
use Smalls\VideoTools\VideoManager;

class VideoParseController extends Controller
{
    public function parse(Request $request)
    {
        $request->validate([
            'url' => 'required|string|url'
        ]);

        $user = $request->user();
        $url = $request->input('url');
        Log::info("video-parse|user_id:{$user->id}|{$url}");
        $urlInfo = parse_url($url);
        $host = $urlInfo['host'];

        $domain = implode('.', array_slice(explode('.', $host), -2));

        [$noWatermarkUrl, $imageUrl] = Cache::remember(md5($url), 3600, function () use($domain, $url) {
            switch ($domain) {
                //抖音
                case 'douyin.com':
                    $data = VideoManager::DouYin()->start($url);
                    break;
                //微视
                case 'qq.com':
                    $data = VideoManager::WeiShi()->start($url);
                    break;
                //快手
                case 'kuaishou.com':
                case 'chenzhongtech.com':
                case 'kuaishouapp.com':
                    $data = VideoManager::KuaiShou()->start($url);
                    break;
                //最右
                case 'izuiyou.com':
                    $data = VideoManager::ZuiYou()->start($url);
                    break;
                //皮皮虾
                case 'hulushequ.com':
                case 'pipix.com':
                    $data = VideoManager::PiPiXia()->start($url);
                    break;
                //皮皮搞笑
                case 'ippzone.com':
                    $data = VideoManager::PiPiGaoXiao()->start($url);
                    break;
                default:
                    abort(Response::HTTP_BAD_REQUEST, '解析失败，请检查地址');

            }
            $videoUrl = Arr::get($data, 'video_url');
            $imageUrl = Arr::get($data, 'img_url');
            abort_if(empty($videoUrl), Response::HTTP_INTERNAL_SERVER_ERROR, '解析失败，请稍后再试');
            return [preg_replace('/^http:/', 'https:', $videoUrl), $imageUrl];
        });

        if ($noWatermarkUrl) {
            $record = Record::firstOrNew(['url' => $url], [
                'host' => $host,
            ]);
            $record->no_water_mark_url = $noWatermarkUrl;
            $record->image_url = $imageUrl;
            $user->records()->save($record);
            return response()->json([
                'url' => $noWatermarkUrl,
                'image' => $imageUrl,
                'preview' => config('app.preview')
            ]);
        } else {
            Cache::forget(md5($url));
            return response()->json(['message' => '转换失败，请检查链接是否有效，或联系客服'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
