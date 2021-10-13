<?php

namespace App\Helper;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{

    public static function uploadImage($path, $image, $disk = 'public', $options = 'public')
    {
        return Storage::disk($disk)->put($path, $image, $options);
    }

    public static function getImageUrl($path, $disk = 'public')
    {
        return Storage::disk($disk)->url($path);
    }

    public static function getImage($path, $disk = 'public')
    {
        return Storage::disk($disk)->get($path);
    }

    public static function deleteImage($path, $disk = 's3')
    {
        return Storage::disk($disk)->delete($path);
    }

    public static function makePublic($path)
    {
        return Storage::disk('s3')->setVisibility($path, 'public');
    }
}
