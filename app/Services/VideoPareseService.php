<?php
/**
 * Created by PhpStorm.
 * User: wangyaqi
 * Date: 2020/3/7
 * Time: 14:17
 */
namespace App\Services;

use App\Services\VideoParse\PiPiGaoXiao;

class VideoPareseService
{
    public static function factory($type)
    {
        switch ($type) {
            case 'PiPiGaoXiao':
                return new PiPiGaoXiao();
        }
    }
}
