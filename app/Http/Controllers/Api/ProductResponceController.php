<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditProductRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductDetalResource;
use App\Http\Resources\ProductResource;
use App\Models\Image;
use App\Models\Product;
use App\Models\Status;
use App\Services\FileManager;

class ProductResponceController extends Controller
{
    public function index()
    {
        return new ProductCollection(Product::all());
    }

    public function product($id)
    {
        return new ProductDetalResource(Product::find($id));
    }

    public function createProduct(ProductRequest $request)
    {
        $message = [
            'message' => 'Ошибка создания продукта',
        ];

        if ($request->user()->cannot('create', Product::class)){
            return $message;
        }

        $product = Product::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'price' => $request['price'],
            'user_id' => $request->user()->id,
            'status_id' => Status::select('id')->where('name', '=', 'Продается')->first()->id,
            'product_type_id' => $request['product_type_id'],
        ]);

        $files = $request->file('images');

        FileManager::saveImage($files, $product->id, "Product");

        if ($product) {
            $message = [
                'message' => 'Продукт создан',
                'product' => new ProductResource($product),
            ];
        }

        return $message;
    }

    public function editProduct(EditProductRequest $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $product = Product::find($request['id']);

        if ($request->user()->cannot('update', $product)){
            return [
                'message' => 'У вас нет доступа к этому продукту'
            ];
        }

        $product->update([
            'name' => $request['name'],
            'description' => $request['description'],
            'price' => $request['price'],
            'user_id' => $request->user()->id,
            'product_type_id' => $request['product_type_id'],
        ]);

        if ($request->file('images')){
            $files = $request->file('images');

            FileManager::saveImage($files, $product->id, "Product");
        }

        return [
            'message' => 'Продукт отредактирован'
        ];
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);

        if (auth('sanctum')->user()->cannot('delete', $product)){
            return [
              'message' => 'У вас нет доступа к этому продукту',
            ];
        }

        $images = Image::all()->where('imageable_id', $product->id)->where('imageable_type', Product::class);
        foreach ($images as $image){
            FileManager::deleteImage($image->path);
            $image->delete();
        }

        $product->delete();

        return [
          'message' => 'Продукт удален',
        ];
    }

    public function deleteProductImage($id)
    {
        $image = Image::where('id', $id)->where('imageable_type', Product::class)->first();
        $product = Product::where('id', '=' ,$image->imageable_id)->first();

        if (auth('sanctum')->user()->cannot('update', $product)){
            return [
                'message' => 'Доступ закрыт'
            ];
        }

        $countImages = Image::where('imageable_id', '=', $product->id)->where('imageable_type', '=', Product::class)->count();
        if($countImages > 1){
            FileManager::deleteImage($image->path);
            $image->delete();
            return [
                'message' => 'Изображение удалено',
            ];
        }
        return [
            'message' => 'У продукта должно быть хотя бы 1 изображение',
        ];
    }

    public function soldProduct($id)
    {
        $product = Product::find($id);

        if (auth('sanctum')->user()->cannot('update', $product)){
            return [
                'message' => 'Доступ закрыт'
            ];
        }

        $product->update([
            'status_id' => Status::select('id')->where('name', '=', 'Продан')->first()->id,
        ]);

        return [
            'message' => 'Продукт отмечен проданым',
        ];
    }

    public function forSaleProduct($id)
    {
        $product = Product::find($id);

        if (auth('sanctum')->user()->cannot('forSaleProduct', $product)){
            return [
                'message' => 'Доступ закрыт'
            ];
        }

        $product->update([
            'status_id' => Status::select('id')->where('name', '=', 'Продается')->first()->id,
        ]);

        return [
            'message' => 'Продукт продается вновь',
        ];
    }

    public function closeProduct($id)
    {
        $product = Product::find($id);

        if (auth('sanctum')->user()->cannot('closeProduct', $product)){
            return [
                'message' => 'Доступ закрыт'
            ];
        }

        $product->update([
            'status_id' => Status::select('id')->where('name', '=', 'Скрыт')->first()->id,
        ]);

        return [
            'message' => 'Продукт скрыт',
        ];
    }
}
