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
                                <button type="button" class="btn btn-primary">Изменить профиль</button>
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
                            <div class="row">

                                <div
                                    class="d-flex justify-content-end align-items-center p-1 border border-primary rounded">

                                    @if(session('success'))
                                        <div class="flex-grow-1 align-items-center alert-success">
                                            <p class="d-flex justify-content-start align-items-center text-success ms-2 fs-4">
                                                {{ session('success') }}</p>
                                        </div>
                                    @else
                                        <div class="flex-grow-1 align-items-center">
                                            <p class="d-flex justify-content-start align-items-center ms-2 fs-5">
                                                Редактирование изображений продукта {{ $product->name }}</p>
                                            @error('error')
                                            <p class="d-flex justify-content-start align-items-center text-danger ms-2 fs-6">
                                                {{ $message }}</p>
                                            @enderror
                                        </div>
                                    @endif
                                </div>

                                @foreach($product->image as $image)

                                    <div class="col-sm-3">
                                        <img src="{{ asset($image->path) }}" alt="product image"
                                             class="rounded mx-auto my-auto d-block" style="width: 150px;">
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <input type="hidden" value="{{ $image->id }}">
                                    </div>

                                    <div class="col-sm-3 mt-3">
                                        <ul class="list-group list-group-flush">
                                            <li class="d-flex justify-content-end align-items-center p-1">
                                                <form class="m-0" action="{{ route('product.image.destroy', $image) }}"
                                                      method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="btn btn-outline-danger">Удалить</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                    <hr>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
