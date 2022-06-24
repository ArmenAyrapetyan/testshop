@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-4">
                    <div class="card-header">Создание продукта</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Название:</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           name="name" value="{{ old('name') }}" required/>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="description" class="col-md-4 col-form-label text-md-end">Описание:</label>

                                <div class="col-md-6">
                                    <textarea type="text" class="form-control @error('description') is-invalid @enderror"
                                              name="description" required>{{ old('description') }}</textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="price"
                                       class="col-md-4 col-form-label text-md-end @error('price') is-invalid @enderror">Цена:</label>

                                <div class="col-md-6">
                                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                                           required value="{{ old('price') }}"/>

                                    @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="product_type_id"
                                       class="col-md-4 @error('product_type_id') is-invalid @enderror col-form-label text-md-end">
                                    Выберите категорию:</label>

                                <div class="col-md-6">
                                    <select class="form-select" name="product_type_id">
                                        @foreach($productTypes as $type)
                                        <option value="{{ $type->id }} {{ old('product_type_id') == $type->id ? 'selected' : '' }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('product_type_id')
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
                                           name="images[]" required multiple value="{{ old('images[]') }}"/>

                                    @error('images[]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Создать</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
