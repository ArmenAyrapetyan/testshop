@extends('layouts.app')

@section('content')

    <div class="album py-5 bg-light">
        <div class="container">
            <h1>Здравствуйте, {{ $userInfo['first_name'] }} {{ $userInfo['last_name'] }}</h1>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

                <a>Ваша почта: {{ $userInfo['email'] }}</a>
                <a>Ваш телефон: {{ $userInfo['phone'] }}</a>

            </div>
        </div>
    </div>

@endsection
