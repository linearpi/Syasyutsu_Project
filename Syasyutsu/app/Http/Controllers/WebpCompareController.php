<?php

namespace App\Http\Controllers;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\Encoders\WebpEncoder;

class WebpCompareController extends Controller
{
    public function show()
    {
        $originalPath   = public_path('images/original.png');        // 元画像はPNG想定
        $webpPath       = public_path('images/original.lossless.webp');

        // imagick ドライバを使って lossless WebP を生成
        $manager = new ImageManager(new ImagickDriver());

        if (! file_exists($originalPath)) {
            abort(404, "オリジナル画像がありません: {$originalPath}");
        }

        // WebP が未生成なら作成
        if (! file_exists($webpPath)) {
            $img = $manager->read($originalPath)
                           ->encode(new WebpEncoder(quality: 100));
            $img->save($webpPath);
        }

        return view('webp_compare', [
            'original' => asset('images/original.png'),
            'webp'     => asset('images/original.lossless.webp'),
        ]);
    }
}
