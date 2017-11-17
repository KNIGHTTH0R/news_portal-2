<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('global-head')
    <link rel="stylesheet" href="{{ asset('api/other/css/custom.css') }}">

</head>
<body>

@yield('global-body')

<script>
    window.onbeforeunload = function() {

        return true;
    };
</script>
<footer class="footer">
    <div class="container">
        <h3>Footer</h3>
    </div>
</footer>
</body>
</html>