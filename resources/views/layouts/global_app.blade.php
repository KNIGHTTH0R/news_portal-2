<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico')}}" type="image/x-icon">
    @yield('global-head')
    <link rel="stylesheet" href="{{ asset('api/other/css/custom.css') }}">
</head>
<body>

@yield('global-body')

<script>
    window.onbeforeunload = function() {

        if (getCookie('active') != undefined){
            var date = new Date(0);
            document.cookie = "active=1; path=/; expires=" + date.toUTCString();
        }


        return true;
    };

    function getCookie(name) {
        var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }
</script>

<footer class="footer">
    <div class="container">
        <h3>Footer</h3>
    </div>
</footer>
<script src="{{ asset('js/common.js') }}"></script>

</body>
</html>