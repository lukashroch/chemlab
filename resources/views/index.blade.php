<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  @include('head')
  <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/app.css')) }}">
  @stack('styles')
</head>
<body id="top">
<div id="app"></div>
<script charset="UTF-8" type="text/javascript" src="{{ asset(mix('js/manifest.js')) }}"></script>
<script charset="UTF-8" type="text/javascript" src="{{ asset(mix('js/vendor.js')) }}"></script>
<script charset="UTF-8" type="text/javascript" src="{{ asset(mix('js/app.js')) }}"></script>
@stack('scripts')
</body>
</html>
