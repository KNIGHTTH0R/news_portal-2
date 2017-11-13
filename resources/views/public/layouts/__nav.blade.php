<nav class="navbar navbar-expand-lg navbar-light bg-light nav-color">
    @auth
        @if(Auth::user()->isAdmin())
        <a class="navbar-brand" href="{{ url('admin') }}">Админ панель</a>
        @endif
    @endauth
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>



        @if(isset($category))
        {{--<ul class="navbar-nav mar-auto">--}}
            {{--<li class="nav-item active">--}}
            {{--<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>--}}
            {{--</li>--}}
            <div class="dropdown mar-auto">
            @foreach($category as $key => $item)
                <div class="btn-group">
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link" href="{{ $key }}">{{ $item }}<span class="sr-only">(current)</span></a>--}}
                {{--</li>--}}

                    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ $item->name }}
                    </button>
                    <div class="dropdown-menu">
                        @foreach($item->news as $var)

                        <a class="dropdown-item" href="{{ url($item->slug .'/'.$var->title) }}">{{ $var->title }}</a>
                        @endforeach
                    </div>
                </div>
            @endforeach
            </div>



        {{--</ul>--}}
        @endif

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
            {{--<a class="dropdown-item" href="#">Action</a>--}}
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                Выйти
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
    </div>
        </ul>
    @endguest
    </div>




</nav>