@extends('layouts.app')

@section('content')

    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

                @foreach($products as $product)
                <div class="col">
                    <div class="card shadow-sm border-top rounded-top">
                        <img class="card-img" src="{{asset(('storage/images/' . $product->image->first()->path))}}" alt="product"/>

                        <div class="card-body border-end border-bottom border-start border-primary rounded-bottom">
                            <p class="card-text">{{ $product->type->name }}</p>
                            <p class="card-text">{{ $product->price }} <small class="text-muted">/ ₽</small></p>
                            <p class="card-text">{{ $product->description }}</p>

                            <div class="d-flex justify-content-end align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-primary">Подробнее</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary">Связаться с продавцом
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>

@endsection
