<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductTypeRequest;
use App\Models\ProductType;
use App\Services\UserPolicyService;

class ProductTypeController extends Controller
{
    public function create()
    {
        if(UserPolicyService::canCreate()) return UserPolicyService::toProfile();
        return view('crud.product_type.create');
    }

    public function store(ProductTypeRequest $request)
    {
        if(UserPolicyService::canCreate()) return UserPolicyService::toProfile();

        ProductType::create($request->all());

        return redirect()->route('profile')->with([
            'success' => 'Тип создан'
        ]);
    }
}
