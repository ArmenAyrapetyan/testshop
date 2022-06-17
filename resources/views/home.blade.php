@extends('layouts.app')

@section('content')

    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

                @for($i=0; $i<50; $i++)
                <div class="col">
                    <div class="card shadow-sm border-top rounded-top">
                        <svg class="bd-placeholder-img card-img-top rounded-top" width="100%" height="225"
                             xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail"
                             preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title>
                            <rect width="100%" height="100%" fill="#55595c"/>
                            <text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
                        </svg>

                        <div class="card-body border-end border-bottom border-start border-primary rounded-bottom">
                            <p class="card-text">Категория</p>
                            <p class="card-text">7250 <small class="text-muted">/ ₽</small></p>
                            <p class="card-text">Описание</p>

                            <div class="d-flex justify-content-end align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-primary">Подробнее</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary">Добавить в корзину
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor

            </div>
        </div>
    </div>

@endsection
