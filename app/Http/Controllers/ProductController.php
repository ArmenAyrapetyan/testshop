<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditProductRequest;
use App\Http\Requests\ProductRequest;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Status;
use App\Services\FileManager;
use App\Services\ProductPolicyService;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $products = Product::all();

        return view('home', compact('products'));
    }

    public function create()
    {
        if(ProductPolicyService::canCreate()) return ProductPolicyService::toProfile();

        $productTypes = ProductType::all();
        return view('crud.product.create', compact('productTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductRequest $request)
    {
        if(ProductPolicyService::canCreate()) return ProductPolicyService::toProfile();

        $request->request->add([
            'user_id' => $request->user()->id,
            'status_id' => Status::select('id')->where('name', '=', 'Продается')->first()->id,
        ]);

        $product = Product::create($request->all());

        if ($product && FileManager::saveImage($request->file('images'), $product->id, Product::class))
            return redirect()->route('profile')->with(['success' => 'Продукт созадан']);

        return redirect()->route('product.create')
            ->withErrors(['error' => 'Ошибка создания продукта, попробуйте позже']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $product = Product::where('id', '=', $id)->first();
        return view('crud.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Product $product)
    {
        if(ProductPolicyService::canUpdate($product)) return ProductPolicyService::toProfile();

        $productTypes = ProductType::all();
        return view('crud.product.edit', compact('product', 'productTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Product  $product
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(EditProductRequest $request, Product $product)
    {
        if(ProductPolicyService::canUpdate($product)) return ProductPolicyService::toProfile();

        $request->request->add([
            'user_id' => $request->user()->id,
        ]);

        $product->update($request->all());

        if ($request->file('images')){
            $files = $request->file('images');

            FileManager::saveImage($files, $product->id, Product::class);
        }

        return redirect(route('profile'))->with('success', 'Продукт изменен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        if(ProductPolicyService::canCloseDeleteAndSale($product)) return ProductPolicyService::toProfile();

        Image::deleteImages($product->id, Product::class);

        $product->delete();

        return redirect()->route('profile')->with(['success' => 'Продукт удален']);
    }

    public function showImageForm(Product $product)
    {
        if(ProductPolicyService::canUpdate($product)) return ProductPolicyService::toProfile();

        return view('crud.product.image', compact('product'));
    }

    public function imageDestroy(Image $image)
    {
        $product = Product::where('id', '=' ,$image->imageable_id)->first();

        if(ProductPolicyService::canUpdate($product)) return ProductPolicyService::toProfile();

        $countImages = Image::where('imageable_id', '=', $product->id)
            ->where('imageable_type', '=', Product::class)->count();

        if($countImages > 1){
            FileManager::deleteImage($image->path);
            $image->delete();
            return redirect()->back()->with(['success' => 'Изображение удалено']);
        }
        return redirect()->back()->withErrors(['error' => 'У продукта должно быть хотя бы 1 изображение']);
    }

    public function soldProduct(Product $product)
    {
        if(ProductPolicyService::canUpdate($product)) return ProductPolicyService::toProfile();

        $product->update(['status_id' => Status::STATUS_SOLD]);

        return redirect()->route('profile')->with(['success' => 'Продукт отмечен проданым']);
    }

    public function forSaleProduct(Product $product)
    {
        if(ProductPolicyService::canCloseDeleteAndSale($product)) return ProductPolicyService::toProfile();

        $product->update(['status_id' => Status::STATUS_SALE]);

        return redirect()->route('profile')->with(['success' => 'Продукт продается вновь']);
    }

    public function closeProduct(Product $product)
    {
        if(ProductPolicyService::canCloseDeleteAndSale($product)) return ProductPolicyService::toProfile();

        $product->update(['status_id' => Status::STATUS_HIDDEN]);

        return back()->with(['success' => 'Продукт скрыт']);
    }
}
