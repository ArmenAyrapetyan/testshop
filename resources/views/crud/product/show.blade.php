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
                            <p class="text-muted mb-4">{{ $product->userid->phone }}</p>
                            <div class="d-flex justify-content-center mb-2">
                                <button type="button" class="btn btn-outline-primary ms-1">Написать</button>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4 mb-lg-0">
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush rounded-3">
                                <li class="list-group-item d-flex justify-content-start align-items-center p-3">
                                    <i class="fas fa-globe fa-lg text-warning"></i>
                                    <p class="mb-0">Чаты</p>
                                </li>

                                @for($i = 1; $i < 10; $i++)
                                    <li class="list-group-item d-flex justify-content-start align-items-center p-3">
                                        <p class="col-sm-8">Чат {{ $i }}</p>
                                        <button class="btn btn-outline-primary col-sm-4">Открыть</button>
                                    </li>
                                @endfor

                            </ul>
                        </div>
                    </div>

                </div>

                <div class="col-lg-8">

                    <div class="card mb-4">

                        <div class="card-body">

                            @foreach($product->image as $image)
                            <div class="row w-50">
                                <img src="{{ asset($image->path) }}" class="card-img" alt="product_image">
                            </div>
                            <hr>
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

                            @for($i=0; $i < 10; $i++)
                            <div class="row m-2 p-1">
                                <div class="col-sm-3">
                                    <p class="mb-0">Пользователь</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">Комментарий</p>
                                </div>
                            </div>
                            @endfor

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
