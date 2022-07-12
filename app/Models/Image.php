<?php

namespace App\Models;

use App\Services\FileManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'imageable_type',
        'imageable_id',
    ];

    public function imagable()
    {
        return $this->morphTo();
    }

    public static function Images($id, $type)
    {
        return Image::where('imageable_id', $id)->where('imageable_type', $type)->get();
    }

    public static function deleteImages($id, $type)
    {
        $images = self::Images($id, $type);

        foreach ($images as $image) {
            FileManager::deleteImage($image->path);
            $image->delete();
        }
    }
}
