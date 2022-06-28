@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-4">
                    <div class="card-header">Комментарий</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('review.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label for="description" class="col-md-4 col-form-label text-md-end">Текст:</label>

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

                            <div class="row mb-3">
                                <label for="images[]" class="col-md-4 col-form-label text-md-end">Выберите изображения:</label>

                                <div class="col-md-6">
                                    <input type="file" class="form-control @error('images[]') is-invalid @enderror"
                                           name="images[]" multiple value="{{ old('images[]') }}"/>

                                    @error('images[]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Отправить комментарий</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
