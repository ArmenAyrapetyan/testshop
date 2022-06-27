<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditProductRequest;
use App\Http\Requests\ProductRequest;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
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
        $product = Product::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'price' => $request['price'],
            'user_id' => $request->user()->id,
            'status_id' => Status::select('id')->where('name', '=', 'Продается')->first()->id,
            'product_type_id' => $request['product_type_id'],
        ]);

        $files = $request->file('images');

        foreach ($files as $file) {
            $upload_folder = "public/images/" . date('Y-m-d');
            $name = $file->getClientOriginalName();
            $name = strstr($name, '.', true);
            $extension = $file->getClientOriginalExtension();
            $name = $name . date('Y-m-d') . '.' . $extension;
            $path = Storage::putFileAs($upload_folder, $file, $name);

            $path = str_replace('public', 'storage', $path);

            Image::create([
                'path' => $path,
                'imageable_type' => Product::class,
                'imageable_id' => $product->id,
            ]);
        }

        if ($product) {
            return redirect()->route('profile')->with([
                'success' => 'Продукт созадан',
            ]);
        }

        return redirect()->route('product.create')->withErrors([
            'error' => 'Ошибка создания продукта, попробуйте позже',
        ]);
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
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Product $product)
    {
        $productTypes = ProductType::all();
        return view('crud.product.edit', compact('product', 'productTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Product  $product
     * @return \Illuminate\Routing\Redirector
     */
    public function update(EditProductRequest $request, Product $product)
    {
        $product->update([
            'name' => $request['name'],
            'description' => $request['description'],
            'price' => $request['price'],
            'user_id' => $request->user()->id,
            'product_type_id' => $request['product_type_id'],
        ]);

        if ($request->file('images')){
            $files = $request->file('images');

            foreach ($files as $file) {
                $upload_folder = "public/images/" . date('Y-m-d');
                $name = $file->getClientOriginalName();
                $name = strstr($name, '.', true);
                $extension = $file->getClientOriginalExtension();
                $name = $name . date('Y-m-d') . '.' . $extension;
                $path = Storage::putFileAs($upload_folder, $file, $name);

                $path = str_replace('public', 'storage', $path);

                Image::create([
                    'path' => $path,
                    'imageable_type' => Product::class,
                    'imageable_id' => $product->id,
                ]);
            }
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
        $images = Image::all()->where('imageable_id', '=', $product->id)->where('imageable_type', '=', Product::class);
        foreach ($images as $image){
            $image->delete();
        }
        $product->delete();

        return redirect()->route('profile')->with([
            'success' => 'Продукт удален',
        ]);
    }

    public function showImageForm(Product $product)
    {
        return view('crud.product.image', compact('product'));
    }

    public function imageDestroy(Image $image)
    {
        $product = Product::where('id', '=' ,$image->imageable_id)->first();
        $countImages = Image::where('imageable_id', '=', $product->id)->where('imageable_type', '=', Product::class)->count();
        if($countImages > 1){
            $image->delete();
            return redirect()->back()->with([
                'success' => 'Изображение удалено',
            ]);
        }
        return redirect()->back()->withErrors([
           'error' => 'У продукта должно быть хотя бы 1 изображение',
        ]);
    }
}
