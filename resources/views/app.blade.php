<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="author" content="Lukas Hroch"/>
  <meta name="description" content="Chemical database management"/>
  <meta name="csrf-token" content="{{ csrf_token() }}"/>
  <title>@yield('title-content')</title>
  <link rel="icon" href="{{ URL::asset('favicon.ico') }}"/>
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/styles.css') }}"/>
</head>
<body role="document">
@include('partials.nav')

<div class="container" role="main" id="main">
  <div id="header" class="page-header">
    <ol class="breadcrumb clearfix">
      @yield('head-content')
    </ol>
  </div>
  <div id="body" class="page-body">
    @if (!$errors->isEmpty())
      @foreach ($errors->all() as $error)
        {{ HtmlEx::alert('danger', $error) }}
      @endforeach
    @endif
    @if (Session::has('flash_message'))
      {{ HtmlEx::alert('success', Session::get('flash_message')) }}
    @endif

    @yield('content')
  </div>
  <div id="footer">
    <div class="row">
      <div class="col-sm-12 text-center">
        &copy; 2012-{{ date('Y') }} <strong>Lukas Hroch</strong> | {{ link_to_route('credits', trans('common.credits')) }}
      </div>
    </div>
  </div>
</div>
<script charset="UTF-8" type="text/javascript" src="{{ URL::asset('js/scripts.js') }}"></script>
@stack('scripts')
</body>
</html>
