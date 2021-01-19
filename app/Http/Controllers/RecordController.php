<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class RecordController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->user()->records()->orderBy('updated_at', 'desc')->paginate($request->input('size', 10))->toArray();
        $data['preview'] = config('app.preview');
        return response()->json($data);
    }

    public function getTotalNum(Request $request)
    {
        $totalNum = $request->user()->records()->count();
        return response()->json([
            'total_num' => $totalNum,
            'preview' => config('app.preview')
        ]);
    }

    public function destroy($id, Request $request)
    {
        $result = $request->user()->records()->where('id', $id)->delete();
        if ($result) {
            return response()->json([
                'message' => '删除成功'
            ]);
        } else {
            return response()->json([
                'message' => '删除失败'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function notice(Request $request)
    {
        $message = $request->input('message');
        Log::info('notice|' . $message);
        myselfNotice($message);
    }
}
