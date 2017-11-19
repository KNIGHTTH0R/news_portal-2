@extends('layouts.global_app')
@section('global-head')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://code.jquery.com/jquery.js"></script>
    <title>@yield('pageTitle')</title>
    @yield('head')
@endsection
@section('global-body')
    @include('public.layouts.__nav')
    @yield('body')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    @yield('end_of_body')
    @include('public.layouts.__modal_subscribe')
    <script>
        window.onload = function () {
            if (getCookie('subscribed') == undefined) {
                setTimeout(subscribe_show, 15000);
            }
            if (typeof is_news_page != 'undefined'){
                active();
                setInterval(active, 3000);
            }
        };

        function subscribe_show() {
            $('#subscribe').modal('show');
        }

        function subscribe_hide() {
            $('#subscribe').modal('hide');
        }

        function getCookie(name) {
            var matches = document.cookie.match(new RegExp(
                "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
            return matches ? decodeURIComponent(matches[1]) : undefined;
        }
    </script>
    <script src="{{ asset('js/public.js') }}"></script>
@endsection