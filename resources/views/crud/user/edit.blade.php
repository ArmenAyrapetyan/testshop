@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-4">
                    <div class="card-header">Изменение профиля</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('user.update', $user) }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label for="first_name" class="col-md-4 col-form-label text-md-end">{{ __('Введите
                                    фамилию:') }}</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                           name="first_name" value="{{ $user->first_name }}" required/>

                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="last_name" class="col-md-4 col-form-label text-md-end">{{ __('Введите имя:') }}</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                           name="last_name" value="{{ $user->last_name }}" required/>

                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="phone" class="col-md-4 col-form-label text-md-end">
                                    Введите номер телефона:</label>

                                <div class="col-md-6">
                                    <input class="form-control @error('phone') is-invalid @enderror"
                                           type="tel" name="phone" pattern="[0-9]{1}-[0-9]{3}-[0-9]{3}-[0-9]{4}"
                                           required value="{{ $user->phone }}"/>

                                    <small>Формат: 7-123-456-7890</small>

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-end @error('email') is-invalid @enderror">
                                    {{ __('Введите адрес электронной почты:') }}</label>

                                <div class="col-md-6">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{ $user->email }}" required autocomplete="email"/>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="avatar" class="col-md-4 col-form-label text-md-end">{{ __('Выберите аватар') }}</label>

                                <div class="col-md-6">
                                    <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                                           name="avatar"/>

                                    @error('avatar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">{{ __('Изменить') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
