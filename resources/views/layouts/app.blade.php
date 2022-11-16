<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>TallyNet By Jayatech</title>

    <!-- Scripts -->
    <script src="{{ asset('baru/js/app.js') }}" defer></script>

    <!-- Fonts -->
    <!-- <link rel="dns-prefetch" href="//fonts.gstatic.com"> -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> 
    <link href="{{ asset('baru/css?family=Nunito') }}" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('baru/images/andika.ico') }}">

    <!-- Styles -->
    <link href="{{ asset('baru/css/app.css') }}" rel="stylesheet">
</head>

  <!-- Mulai 
  <div style="height:100%"> 
  <div>
  This is the fixed header
  </div>
  <div style="overflow:auto; max-height: 90%;">
  <table><tbody>
 Selesai -->


<body>
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

<!-- Mulai 
</table></tbody>
</div>
<div>
This should always be visible at the bottom of the window
</div>
</div>
 Selesai -->

</html>
