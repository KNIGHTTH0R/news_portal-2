<nav class="navbar navbar-expand-lg navbar-light bg-light nav-color">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <div class="navbar-nav">
            @auth
                @if(Auth::user()->isAdmin())
                    <a class="navbar-brand" href="{{ url('admin') }}">Админ панель</a>
                @endif
            @endauth
                    <a class="navbar-brand btn btn-primary backToSite" href="{{ url('/') }}">На главную</a>
        </div>
                @if(isset($category))

                    @foreach($category as $key => $item)
                        <div class="mar-auto btn-group">
                            <a href="{{action('IndexController@newsFromCategory', ['slug' => $item->slug])}}" class="btn btn-danger">{{ $item->name }}</a>

                            <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu">
                                @foreach($item->news as $var)

                                <a class="dropdown-item" href="{{ url($item->slug .'/'.$var->title) }}">{{ $var->title }}</a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif

        </div>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav2" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav2">
        <div class="navbar-nav mar-left">

                <ul class="navbar-nav ml-auto">

                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Войти</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Регистрация</a></li>
                    @else



                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ action('NewsController@index') }}">Мои статьи</a>
                            <a class="dropdown-item" href="{{ action('NewsController@create') }}">Создать статью</a>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                Выйти
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                </ul>
            </div>
        </div>
    @endguest
    </div>

</nav>