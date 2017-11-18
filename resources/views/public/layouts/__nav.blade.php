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
            @if (url()->current() != url('/'))
                    <a class="navbar-brand btn btn-primary backToSite" href="{{ url('/') }}">На главную</a>
            @endif
        </div>
        <div class="mar-auto btn-group ">
            <div class="btn-group">
                <a href="{{action('IndexController@analyticalNews')}}" class="btn btn-danger">Аналитические статьи</a>
                <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">
                    @foreach($analytical as $item)
                        <li class="dropdown-item dropdown-submenu">
                            <a tabindex="-1" class="dropdown-item" href="{{ url('analytical/'.$item->slug) }}">{{ $item->title }}</a>
                            <ul class="dropdown-menu">
                                <h6 class="dropdown-header">{{ $item->category->name }}</h6>
                                @foreach($item->category->news()->limit(5)->get() as $var)
                                    <li class="dropdown-item dropdown-submenu">
                                        <a href="{{ action('IndexController@show', ['category' => $item->category->slug, 'slug' => $var->slug]) }}"
                                            bypass class="dropdown-item interaction" data-module="git" data-action="status">
                                            <i class="fa fa-fw fa-flag"></i>&nbsp; {{ $var->title }}
                                        </a>
                                        <ul class="dropdown-menu">
                                            <h6 class="dropdown-header">Тэги</h6>
                                                @foreach($var->tag as $tag)
                                                    <li>
                                                        <a href="{{ action('IndexController@newsFromTag', ['tag' => $tag->name]) }}"
                                                        bypass class="dropdown-item interaction" data-module="git" data-action="status">
                                                            <i class="fa fa-fw fa-flag"></i>&nbsp; {{ $tag->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </div>
            </div>
                @if(isset($category))
                    @foreach($category as $key => $item)
                        @if ($item->isNotEmpty())
                            <div class="btn-group">
                                <a href="{{action('IndexController@newsFromCategory', ['slug' => $item->first()->category->slug])}}"
                                   class="btn btn-danger">{{ $item->first()->category->name }}
                                </a>
                                <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu">
                                    @foreach($item as $new)
                                        <a class="dropdown-item" href="{{ url($item->first()->category->slug .'/'.$new->slug) }}">{{ $new->title }}</a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
        </div>

    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav2" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div>
        <form class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="search_input">
            <i class="material-icons">search</i>
        </form>
        <div id="search_result"></div>
    </div>
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
                    @endguest
                </ul>
        </div>
    </div>
</nav>