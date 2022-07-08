<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class FileManager
{
    public static function saveImage($files, $id, $type)
    {
        $isSaved = false;
        foreach ($files as $file) {
            $upload_folder = "public/images/" . date('Y-m-d');
            $name = $file->getClientOriginalName();
            $name = strstr($name, '.', true);
            $extension = $file->getClientOriginalExtension();
            $name = $name . date('Y-m-d') . '.' . $extension;
            $path = Storage::putFileAs($upload_folder, $file, $name);

            $path = str_replace('public', 'storage', $path);

            if ($type == "Product") {
                Image::create([
                    'path' => $path,
                    'imageable_type' => Product::class,
                    'imageable_id' => $id,
                ]);
                $isSaved = true;
            }
            if ($type == "User") {
                Image::create([
                    'path' => $path,
                    'imageable_type' => User::class,
                    'imageable_id' => $id,
                ]);
                $isSaved = true;
            }
        }
        return $isSaved;
    }

    public static function deleteImage($imagePath)
    {
        $path = str_replace("storage/", "public/", $imagePath);
        Storage::delete($path);
        return $path;
    }
}
