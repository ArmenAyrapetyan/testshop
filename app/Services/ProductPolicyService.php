<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductPolicyService
{
    public static function canCreate()
    {
        if (auth()->user()->cannot('create', Product::class))
            return true;
        return false;
    }

    public static function canUpdate(Product $product)
    {
        if (Auth::user()->cannot('update', $product))
            return true;
        return false;
    }

    public static function canCloseDeleteAndSale(Product $product)
    {
        if (auth()->user()->cannot('closeDeleteAndSale', $product))
            return true;
        return false;
    }

    public static function toProfile($isAPI = false)
    {
        if ($isAPI){
            return [
                'message' => 'доступ закрыт'
            ];
        }
        return redirect()->route('profile')->withErrors(['error' => 'Доступ закрыт']);
    }
}
