<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <meta name="author" content="Lukas Hroch"/>
  <meta name="description" content="Chemical database management"/>
  <meta name="csrf-token" content="{{ csrf_token() }}"/>
  <title>@yield('title-content')</title>
  <link rel="icon" href="{{ asset('favicon.ico') }}"/>
  <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/styles.css')) }}"/>
</head>
<body role="document">
@include('partials.navbar')

<div class="container-fluid" role="main" id="main">
  <div id="body" class="mb-4">
    @if (!$errors->isEmpty())
      @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible">
          <span class="fa fa-common-alert-danger" aria-hidden="true"></span>
          {{ $error }}
          <a class="close float-right"><span class="fa fa-times"></span></a>
        </div>
      @endforeach
    @endif
    @includeWhen(session()->has('flash_message'), 'partials.alert', ['type' => 'success', 'text' => session()->get('flash_message')])

    @yield('content')
  </div>
  <div id="footer">
    <div class="row">
      <div class="col-sm-12 text-center">
        &copy; 2012-{{ date('Y') }} <strong>Lukas Hroch</strong>
        | {{ link_to_route('credits', trans('common.credits')) }}
      </div>
    </div>
  </div>
</div>
<script charset="UTF-8" type="text/javascript" src="{{ asset(mix('js/scripts.js')) }}"></script>
@stack('scripts')
</body>
</html>
