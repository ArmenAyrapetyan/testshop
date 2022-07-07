{{--Админ--}}
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
                    @endif

                    @error('error')
                    <div class="flex-grow-1 align-items-center alert-danger">
                        <p class="d-flex justify-content-start align-items-center text-danger ms-2 fs-4">
                            {{ $message }}</p>
                    </div>
                    @enderror

                    <a class="d-flex justify-content-end align-items-center p-1"
                       href="{{ route('type.create') }}">
                        <button class="btn btn-outline-primary">Создать тип</button>
                    </a>
                    <a class="d-flex justify-content-end align-items-center p-1"
                       href="#">
                        <button class="btn btn-outline-primary">Пользователи</button>
                    </a>
                </div>

                @foreach(auth()->user()->role->unreadNotifications as $notify)
                    @foreach($products as $product)
                        @if($product->id == $notify['data']['product_id'])
                            <div class="col-sm-3">
                                <img src="{{ asset($product->image->first()->path) }}" alt="avatar"
                                     class="rounded mx-auto my-auto d-block" style="width: 150px;">
                            </div>

                            <div class="col-sm-6 mb-3">
                                <ul class="list-group list-group-flush rounded-3">
                                    <li class="d-flex justify-content-start align-items-center p-2">
                                        Название: {{ $product->name }}</li>
                                    <li class="d-flex justify-content-start align-items-center p-2">
                                        Категория: {{ $product->type->name }}</li>
                                    <li class="d-flex justify-content-start align-items-center p-2">
                                        Статус: {{ $product->status->name }}</li>
                                    <li class="d-flex justify-content-start align-items-center p-2">
                                        Описание: {{ $product->description }}</li>
                                    <li class="d-flex justify-content-start align-items-center p-2">
                                        Цена: {{ $product->price }}</li>
                                </ul>
                            </div>

                            <div class="col-sm-3 mt-3">
                                <ul class="list-group list-group-flush">
                                    <li class="d-flex justify-content-end align-items-center p-1">
                                        <a href="{{ route('product.show', $product->id) }}">
                                            <button class="btn btn-outline-primary">Открыть</button>
                                        </a>
                                    </li>
                                    <li class="d-flex justify-content-end align-items-center p-1">
                                        <form class="m-0" action="{{ route('product.destroy', $product) }}"
                                              method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-outline-danger">Удалить</button>
                                        </form>
                                    </li>
                                    @if ($product->status_id != 4)
                                        <li class="d-flex justify-content-end align-items-center p-1">
                                            <form class="m-0" action="{{ route('product.notify.delete', $notify->id) }}"
                                                  method="post">
                                                @csrf
                                                <button class="btn btn-outline-primary">Прочитано</button>
                                            </form>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <hr>
                        @endif
                    @endforeach
                @endforeach
            </div>

        </div>
    </div>
</div>
