<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{Vite::asset('resources/adminlte/dist/css/adminlte.min.css')}} ">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{Vite::asset('resources/adminlte/plugins/fontawesome-free/css/all.min.css ')}} ">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{Vite::asset('resources/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css ')}} ">


    @vite(['resources/css/app.css',
    'resources/js/app.js',
    'resources/sass/app.scss',
    'resources/sass/_variables.scss',

])





</head>
<body>
<div id="app">

</div>
</body>
<!-- ./wrapper -->

<!-- jQuery -->
<script src=" {{Vite::asset('resources/adminlte/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src=" {{Vite::asset('resources/adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src=" {{Vite::asset('resources/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- overlayScrollbars -->
<script src=" {{Vite::asset('resources/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src=" {{Vite::asset('resources/adminlte/dist/js/adminlte.js')}}"></script>




</html>



<?php
