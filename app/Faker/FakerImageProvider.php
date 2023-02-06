<?php

namespace App\Faker;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

final class FakerImageProvider extends Base
{
    public function picsum(string $dir = '', int $w = 500, int $h = 500, string $format = 'jpg'): string
    {
        $url = 'https://picsum.photos' . '/' . $w . '/' . $h . '.' . $format . '?random=' . rand(1, 9);

        $fileName = md5(uniqid(empty($_SERVER['SERVER_ADDR']) ? '' : $_SERVER['SERVER_ADDR'], true));

        $filepath = $dir . DIRECTORY_SEPARATOR . $fileName . '.' . $format;

        $response = Http::get($url);

        if($response->status() == 200) {
            $file = Http::get($response->handlerStats()['url']);
            if($file->status() == 200) {
                Storage::put(
                    $filepath,
                    $file->body()
                );
//                dump($filepath);
//                return '/storage/app/public/' . $filepath;
                return $filepath;
            }
        } else {
            return false;
        }

        return false;
    }
}
