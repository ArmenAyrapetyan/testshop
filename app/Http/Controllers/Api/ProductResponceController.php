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
use App\Services\ProductPolicyService;

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
        $message = ['message' => 'Ошибка создания продукта'];

        if(ProductPolicyService::canCreate()) return ProductPolicyService::toProfile(true);

        $request->request->add([
            'user_id' => $request->user()->id,
            'status_id' => Status::select('id')->where('name', '=', 'Продается')->first()->id,
        ]);

        $product = Product::create($request->all());

        if ($product && FileManager::saveImage($request->file('images'), $product->id, Product::class)) {
            $message = [
                'message' => 'Продукт создан',
                'product' => new ProductResource($product),
            ];
        }

        return $message;
    }

    public function editProduct(EditProductRequest $request)
    {
        $request->validate(['id' => 'required']);

        $product = Product::find($request['id']);

        if(ProductPolicyService::canUpdate($product)) return ProductPolicyService::toProfile(true);

        $request->request->add(['user_id' => $request->user()->id,]);

        $product->update($request->all());

        if ($request->file('images'))
            FileManager::saveImage($request->file('images'), $product->id, "Product");

        return ['message' => 'Продукт отредактирован'];
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);

        if(ProductPolicyService::canCloseDeleteAndSale($product)) return ProductPolicyService::toProfile(true);

        Image::deleteImages($product->id, Product::class);

        $product->delete();

        return ['message' => 'Продукт удален'];
    }

    public function deleteProductImage($id)
    {
        $image = Image::where('id', $id)->where('imageable_type', Product::class)->first();
        $product = Product::find($image->imageable_id);

        if(ProductPolicyService::canCloseDeleteAndSale($product)) return ProductPolicyService::toProfile(true);

        $countImages = Image::Images($product->id, Product::class)->count();

        if ($countImages > 1) {
            FileManager::deleteImage($image->path);
            $image->delete();
            return ['message' => 'Изображение удалено',];
        }

        return ['message' => 'У продукта должно быть хотя бы 1 изображение'];
    }

    public function soldProduct($id)
    {
        $product = Product::find($id);

        if(ProductPolicyService::canUpdate($product)) return ProductPolicyService::toProfile(true);

        $product->update(['status_id' => Status::STATUS_SOLD]);

        return ['message' => 'Продукт отмечен проданым'];
    }

    public function forSaleProduct($id)
    {
        $product = Product::find($id);

        if(ProductPolicyService::canCloseDeleteAndSale($product)) return ProductPolicyService::toProfile(true);

        $product->update(['status_id' => Status::select('id')->where('name', '=', 'Продается')->first()->id,]);

        return ['message' => 'Продукт продается вновь'];
    }

    public function closeProduct($id)
    {
        $product = Product::find($id);

        if(ProductPolicyService::canCloseDeleteAndSale($product)) return ProductPolicyService::toProfile(true);

        $product->update(['status_id' => Status::select('id')->where('name', '=', 'Скрыт')->first()->id]);

        return ['message' => 'Продукт скрыт'];
    }
}
