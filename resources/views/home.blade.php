@extends('layouts.app')

@section('content')

    <div class="album py-5 bg-light">
        <div class="container">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

                @foreach($products as $product)
                    @if($product->status->name == "Продается")
                        <div class="col">
                            <div class="card shadow-sm border-top border-primary rounded-top align-items-center">
                                <img class="card-img w-75" src="{{asset(($product->image->first()->path))}}"
                                     alt="product"/>

                                <div
                                    class="card-body rounded-bottom">
                                    <p class="card-text">Название: {{ $product->name }}</p>
                                    <p class="card-text">Категория: {{ $product->type->name }}</p>
                                    <p class="card-text">Цена: {{ $product->price }} <small class="text-muted">/
                                            ₽</small></p>
                                    <p class="card-text">Описание: {{ $product->description }}</p>

                                    <div class="d-flex justify-content-end align-items-center">
                                        <div class="btn-group">
                                            <a href="{{ route('product.show', $product->id) }}">
                                                <button type="button" class="btn btn-sm btn-outline-primary">Подробнее
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

            </div>
        </div>
    </div>

@endsection
