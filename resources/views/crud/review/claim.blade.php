@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-4">
                    <div class="card-header">Жалоба</div>

                    <div class="card-body">

                        @if(session('success'))
                            <div class="flex-grow-1 align-items-center alert-success">
                                <p class="d-flex justify-content-start align-items-center text-success ms-2 fs-4">
                                    {{ session('success') }}</p>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('review.claimstore') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label for="description" class="col-md-4 col-form-label text-md-end">Текст жалобы:</label>

                                <div class="col-md-6">
                                    <textarea type="text" class="form-control @error('text') is-invalid @enderror"
                                              name="text" required>{{ old('text') }}</textarea>

                                    <input class="d-none" type="hidden" name="product_id" value="{{ $id }}">

                                    @error('text')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Отправить жалобу</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
