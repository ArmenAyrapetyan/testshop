@extends('layouts.app')

@section('content')

    <section style="background-color: #eee;">
        <div class="container py-5">

            <div class="row">

                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="{{ asset($userInfo->image->path) }}" alt="avatar"
                                 class="rounded-circle img-fluid" style="width: 150px;">
                            <h5 class="my-3">{{ $userInfo->last_name . ' ' . $userInfo->first_name }}</h5>
                            <p class="text-muted mb-1">{{ $userInfo->email }}</p>
                            <p class="text-muted mb-1">{{ $userInfo->phone }}</p>
                            <p class="text-muted mb-4">{{ $userInfo->role->name }}</p>
                            <div class="d-flex justify-content-center mb-2">
                                <a href="{{ route('user.edit', $userInfo) }}">
                                    <button type="button" class="btn btn-primary">Изменить профиль</button>
                                </a>
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

                @if(auth()->user()->role_id == '1')
                    @include('profile.roles.admin')
                @else
                    @include('profile.roles.user')
                @endif

            </div>
        </div>
    </section>

@endsection
