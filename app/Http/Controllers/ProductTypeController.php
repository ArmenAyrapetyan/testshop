<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductTypeRequest;
use App\Models\ProductType;

class ProductTypeController extends Controller
{
    public function create()
    {
        if (auth()->user()->cannot('create', ProductType::class)){
            return redirect()->route('profile')->withErrors([
                'error' => 'Нет доступа'
            ]);
        }

        return view('crud.product_type.create');
    }

    public function store(ProductTypeRequest $request)
    {
        if ($request->user()->cannot('create', ProductType::class)){
            return redirect()->route('profile')->withErrors([
                'error' => 'Нет доступа'
            ]);
        }

        ProductType::create([
            'name' => $request['name'],
        ]);

        return redirect()->route('profile')->with([
            'success' => 'Тип создан'
        ]);
    }
}
