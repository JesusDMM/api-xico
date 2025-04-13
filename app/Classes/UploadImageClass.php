<?php

namespace App\Classes;

use Illuminate\Support\Str;

use Exception;

class UploadImageClass
{
    public static function uploadImage($request)
    {
        try {
            $uuid = Str::uuid()->toString();
            $image = $request->file('image');
            $imageName = $uuid . "." . $image->getClientOriginalExtension();
            $destination = public_path('img/users/');
            $image->move($destination, $imageName);
            return $imageName;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function getImageName($request)
    {
        $imageName = null;
        if ($request->has('image')) {
            $imageName = self::uploadImage($request);
        }
        return $imageName;
    }
}
