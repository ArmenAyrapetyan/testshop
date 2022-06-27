@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-4">
                <div class="card-header">Верификация почты</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Ссылка на подтверждение почты отправлена, перейдите по ней
                        </div>
                    @endif
                    Вам на почту было отправлено письмо для её подтверждения, перейдите по ссылке в письме <br>
                    Если вы не получили писмо,
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">нажмите для отправки нового письма</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
