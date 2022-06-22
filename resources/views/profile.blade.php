@extends('layouts.app')

@section('content')

    <section style="background-color: #eee;">
        <div class="container py-5">

            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="{{ asset("storage/images/" . $userInfo->image->path) }}" alt="avatar"
                                 class="rounded-circle img-fluid" style="width: 150px;">
                            <h5 class="my-3">{{ $userInfo->first_name . ' ' . $userInfo->last_name }}</h5>
                            <p class="text-muted mb-1">{{ $userInfo->email }}</p>
                            <p class="text-muted mb-4">{{ $userInfo->phone }}</p>
                            <div class="d-flex justify-content-center mb-2">
                                <button type="button" class="btn btn-primary">Изменить профиль</button>
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
                            <div class="row">
                                @for($i = 1; $i < 10; $i++)
                                    <div class="col-sm-3 mt-1">
                                        <img src="{{ asset("storage/images/" . $userInfo->image->path) }}" alt="avatar"
                                             class="img-fluid" style="width: 150px;">
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <ul class="list-group list-group-flush rounded-3">
                                            <li class="d-flex justify-content-start align-items-center p-3">
                                                Имя {{ $i }}</li>
                                            <li class="d-flex justify-content-start align-items-center p-3">
                                                Описание {{ $i }}</li>
                                            <li class="d-flex justify-content-start align-items-center p-3">
                                                Цена {{ $i }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-3 mt-3">
                                        <ul class="list-group list-group-flush">
                                            <li class="d-flex justify-content-end align-items-center p-1">
                                                {{--                                                <button class="btn btn-outline-primary">Подробнее</button>--}}
                                            </li>
                                            <li class="d-flex justify-content-end align-items-center p-1">
                                                <button class="btn btn-outline-primary">Удалить</button>
                                            </li>
                                            <li class="d-flex justify-content-end align-items-center p-1">
                                                <button class="btn btn-outline-primary">Изменить</button>
                                            </li>
                                        </ul>
                                    </div>
                                @endfor
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
