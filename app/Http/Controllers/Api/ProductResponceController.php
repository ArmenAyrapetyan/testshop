<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResponce;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductResponceController extends Controller
{
    public function index()
    {
        return new ProductResponce(Product::all());
    }
}
