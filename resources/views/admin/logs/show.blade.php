@extends('app')

@section('title', trans('logs.index'))

@section('content')
  <div class="card">
    <div class="card-body">
      <div id="accordion">
        @foreach($log->content as $stack)
          @if (!$stack)
            @continue
          @endif
          <div class="card">
            <div class="card-header" id="h_{{ $loop->iteration }}">
              <h5 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#log_{{ $loop->iteration }}"
                        aria-expanded="true" aria-controls="log_{{ $loop->iteration }}">
                  {{ str_limit($stack, 100, '') }}
                </button>
              </h5>
            </div>
            <div id="log_{{ $loop->iteration }}" class="collapse" aria-labelledby="h_{{ $loop->iteration }}"
                 data-parent="#accordion">
              <div class="card-body">
                <code>
                  {{ $stack }}
                </code>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endsection
