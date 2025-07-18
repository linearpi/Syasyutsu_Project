<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Encoders\PngEncoder; // ← JPEG → PNG に変更

class ImageCompareController extends Controller
{
    public function show()
    {
        $originalPath = public_path('images/original.png');
        $compressedBase = public_path('images/compressed_');

        $manager = new ImageManager(new GdDriver());

        if (!file_exists($originalPath)) abort(404);

        for ($i = 0; $i <= 9; $i++) {
            $path = $compressedBase . $i . '.png';
            if (!file_exists($path)) {
                $img = $manager->read($originalPath);
                $img->toPng(indexed: true)->save($path);
            }
        }

        return view('image_compare', [
            'original' => asset('images/original.png'),
            'precompressed' => collect(range(0, 9))->mapWithKeys(function ($rate) {
                return [$rate => asset("images/compressed_{$rate}.png")];
            }),
            'custom' => null
        ]);
    }

    public function compressCustom(Request $request)
    {
        $level = max(0, min(9, (int) $request->input('compression'))); // PNG圧縮レベル 0?9
        $originalPath = public_path('images/original.png');
        $customPath   = public_path("images/custom_{$level}.png");

        $manager = new ImageManager(new GdDriver());

        $img = $manager->read($originalPath);
        $img->toPng(indexed: true)->save($customPath);

        return view('image_compare', [
            'original' => asset('images/original.png'),
            'precompressed' => collect(range(0, 9))->mapWithKeys(function ($rate) {
                return [$rate => asset("images/compressed_{$rate}.png")];
            }),
            'custom' => [
                'rate' => $level,
                'url'  => asset("images/custom_{$level}.png")
            ]
        ]);
    }
}
