@extends('layouts.app')

@section('content')

    <section style="background-color: #eee;">
        <div class="container py-5">

            <div class="row">

                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="{{ asset($product->userid->image->path) }}" alt="avatar"
                                 class="rounded-circle img-fluid" style="width: 150px;">
                            <h5 class="my-3">{{ $product->userid->first_name . ' ' . $product->userid->last_name }}</h5>
                            <p class="text-muted mb-1">{{ $product->userid->email }}</p>
                            <p class="text-muted mb-1">{{ $product->userid->phone }}</p>
                            @auth
                                @if(auth()->user()->role_id == 1)
                                    <p class="text-muted mb-1"> Кол-во банов: {{ $product->userid->ban_count }} </p>
                                    <p class="text-muted mb-1"> Статус: {{ $product->userid->role->name }} </p>
                                @endif
                            @endauth
                            <div class="d-flex justify-content-center mb-2 row-cols-2">
                                <button type="button" class="btn btn-outline-primary ms-1 col">Написать</button>
                                @auth
                                    @if(auth()->user()->role_id == 1 && $product->userid->role_id != 3)
                                        <a href="{{ route('user.block', $product->userid->id) }}">
                                            <button type="button" class="btn btn-outline-danger ms-1">Заблокировать
                                            </button>
                                        </a>
                                    @endif
                                @endauth
                            </div>

                        </div>
                    </div>

                    <div class="card mb-4 mb-lg-0">
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush rounded-3">
                                <li class="list-group-item d-flex justify-content-start align-items-center p-3">
                                    <i class="fas fa-globe fa-lg text-warning"></i>
                                    <p class="mb-0 mx-auto">Другие товары продавца</p>
                                </li>

                                @foreach($product->userid->products as $userProduct)
                                    @if($userProduct->id != $product->id)
                                        @if($userProduct->status->name == "Продается")
                                            <li class="list-group-item d-flex justify-content-start align-items-center p-3">
                                                <div class="col-sm-6">
                                                    <img class="w-75" alt="Изображение товара"
                                                         src="{{ asset($userProduct->image->first()->path) }}">
                                                </div>
                                                <div class="col-sm-6 align-items-center">
                                                    <p>{{ $userProduct->name }}</p>
                                                    <a href="{{ route('product.show', $userProduct->id) }}">
                                                        <button class="btn btn-outline-primary mx-auto">Открыть</button>
                                                    </a>
                                                </div>
                                            </li>
                                        @endif
                                    @endif
                                @endforeach

                            </ul>
                        </div>
                    </div>

                </div>

                <div class="col-lg-8">

                    <div class="card mb-4">

                        <div class="card-body">

                            @if(session('success'))
                                <div class="flex-grow-1 align-items-center alert-success">
                                    <p class="d-flex justify-content-start align-items-center text-success ms-2 fs-4">
                                        {{ session('success') }}</p>
                                </div>
                            @endif

                            @foreach($product->image as $image)
                                <div class="row w-50 mx-auto">
                                    <img src="{{ asset($image->path) }}" class="card-img" alt="product_image">
                                </div>
                            @endforeach

                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Название:</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $product->name }}</p>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Тип:</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $product->type->name }}</p>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Описание:</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $product->description }}</p>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Цена:</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $product->price }} <small
                                            class="text-muted">/₽</small></p>
                                </div>
                            </div>
                            <hr>

                            @auth
                                @if(auth()->user()->role_id == 1)
                                    <div>
                                        <a href="#">
                                            <button class="btn btn-outline-warning">
                                                Жалоб: {{ $product->countClaim($product->id) }}</button>
                                        </a>
                                    </div>
                                    @if($product->status->name != "Скрыт" && $product->status->name != "На рассмотрении")
                                        <div class="d-flex justify-content-end align-items-center p-1">
                                            <a href="{{ route('product.close', $product) }}">
                                                <button class="btn btn-outline-primary">Скрыть</button>
                                            </a>
                                        </div>
                                    @endif
                                    @if($product->status->name == "Скрыт" || $product->status->name == "На рассмотрении")
                                        <div class="d-flex justify-content-end align-items-center p-1">
                                            <a href="{{ route('product.forsale', $product) }}">
                                                <button class="btn btn-outline-primary">Разблокировать</button>
                                            </a>
                                        </div>
                                    @endif
                                @else
                                    <div>
                                        <a href="{{ route('review.claimcreate', $product->id) }}">
                                            <button class="btn btn-outline-warning">Пожаловаться</button>
                                        </a>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <div class="card mb-4">

                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Комментарии</p>
                                </div>
                            </div>
                            <hr>

                            @if($product->reviews->count() > 0)
                                @foreach($product->reviews as $review)
                                    @if(!$review->is_claim)
                                        <div class="row w-50">
                                            @foreach($review->images as $image)
                                                <div class="col">
                                                    <img class="img-fluid" src="{{ asset($image->path) }}"
                                                         alt="reviewImage">
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="row m-2 p-1">
                                            <div class="col-sm-3">
                                                <p class="mb-0">{{ $review->user->last_name . ' ' . $review->user->first_name  }}</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">{{ $review->text }}</p>
                                            </div>
                                        </div>
                                        <hr>
                                    @endif
                                @endforeach
                            @else
                                <div class="row m-2 p-1">
                                    <p class="mb-0">Комментариев нет</p>
                                </div>
                            @endif

                            <div
                                class="d-flex justify-content-end align-items-center p-1">
                                <a class="d-flex justify-content-end align-items-center p-1"
                                   href="{{ route('review.create', $product->id) }}">
                                    <button class="btn btn-outline-primary">Написать комментарий</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
