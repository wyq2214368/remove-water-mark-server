<?php

namespace App\Console\Commands;

use App\Http\Controllers\VideoParseController;
use App\Models\Record;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class AutoTrans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:trans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'auto trans links';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = User::first();
        if (empty($user)) {
            $this->error('没有用户');
            return false;
        }
        $client = new Client();

        $urlList = Record::get('url');

        $urlList->each(function ($item) use($client, $user) {
            try{
                $this->info("自动解析刷缓存｜{$item->url}");

                $request = Request::create(route('video.parse'), 'POST', [
                    'url' => $item->url,
                ])->setUserResolver(function () use($user){
                    return $user;
                });

                $request->headers->set('Accept', 'application/json');
                $request->headers->set('Authorization', "Bearer {$user->api_token}");
                $response = app(VideoParseController::class)->parse($request)->getContent();
                $this->info($response);
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }
        });
        return true;
    }
}
