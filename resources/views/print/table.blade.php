<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <title>Print Table</title>
  @include('head')
  <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/app.css')) }}">
  <style>
    body {
      margin: 20px
    }
  </style>
</head>
<body>
<table class="table table-bordered table-condensed table-striped">
  @foreach($data as $row)
    @if ($row == reset($data))
      <tr>
        @foreach($row as $key => $value)
          <th>{!! $key !!}</th>
        @endforeach
      </tr>
    @endif
    <tr>
      @foreach($row as $key => $value)
        @if(is_string($value) || is_numeric($value))
          <td>{!! $value !!}</td>
        @else
          <td></td>
        @endif
      @endforeach
    </tr>
  @endforeach
</table>
</body>
</html>
