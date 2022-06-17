<header>
    <div class="navbar navbar-light bg-white shadow-sm">
        <div class="container">
            <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center">
                <strong>Test Shop</strong>
            </a>
            <div class="d-flex justify-content-end align-items-center">
                <div class="btn-group">
                    @guest
                    <a href="{{ route('login') }}">
                        <button class="btn btn-outline-primary m-1" type="button">
                            Войти
                        </button>
                    </a>
                    @endguest
                    @auth
                    <a href="#">
                        <button class="btn btn-outline-primary m-1" type="button">
                            Личный кабинет
                        </button>
                    </a>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="btn btn-outline-danger m-1" type="submit">
                            Выйти
                        </button>
                    </form>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</header>
