<?php

namespace App\Http\Controllers;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Encoders\JpegEncoder;

class ImageCompareController extends Controller
{
    public function show()
    {
        $originalPath = public_path('images/original.jpg');
        $manager = new ImageManager(new GdDriver());

        if (!file_exists($originalPath)) {
            abort(404, "オリジナル画像がありません: {$originalPath}");
        }

        // 圧縮画像の保存先と品質ごとのURLの配列を生成
        $compressedImages = [];

        for ($i = 0; $i <= 9; $i++) {
            $rate = $i * 10;
            $compressedFilename = "compressed{$rate}.jpg";
            $compressedPath = public_path("images/{$compressedFilename}");

            if (!file_exists($compressedPath)) {
                $image = $manager->read($originalPath);
                $image->encode(new JpegEncoder(quality: $rate))->save($compressedPath);
            }

            $compressedImages[] = [
                'rate' => $rate,
                'url'  => asset("images/{$compressedFilename}")
            ];
        }

        return view('image_compare', [
            'original' => asset('images/original.jpg'),
            'compressedImages' => $compressedImages,
        ]);
    }
}
