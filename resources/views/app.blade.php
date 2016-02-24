<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <meta name="author" content="Lukas Hroch"/>
  <meta name="description" content=""/>
  <meta name="csrf-token" content="{{ csrf_token() }}"/>
  <title>@yield('title-content')</title>
  <link rel="icon" href="{{ URL::asset('favicon.ico') }}"/>
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/styles.css') }}"/>
</head>
<body role="document">
@include('partials.nav')

<div class="container" role="main" id="main">
  <div class="page-header">
    <h3>@yield('head-content')</h3>
  </div>
  @if ($errors->has())
    @foreach ($errors->all() as $error)
      {{ HtmlEx::alert($error, 'danger') }}
    @endforeach
  @endif
  @if (Session::has('flash_message'))
    {{ HtmlEx::alert(Session::get('flash_message'), 'success') }}
  @endif

  @yield('content')
</div>
<br/>

<div class="container">
  <div class="col-sm-12 text-center">
    &copy; 2012-2016 <strong>Lukas Hroch</strong> | {{ link_to_route('credits', trans('common.credits')) }}
  </div>
</div>
<script charset="UTF-8" type="text/javascript" src="{{ URL::asset('js/scripts.js') }}"></script>
</body>
</html>
