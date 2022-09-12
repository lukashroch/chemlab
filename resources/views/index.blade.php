<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  @include('head')
  @vite(['resources/scss/app.scss'])
  @stack('styles')
</head>
<body id="top">
<div id="app"></div>
@vite(['resources/js/main.ts'])
@stack('scripts')
</body>
</html>
