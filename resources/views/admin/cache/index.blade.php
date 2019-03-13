@extends('app')

@section('title', __('cache.title'))

@section('content')
  <div class="card-deck">
    <div class="card">
      <h4 class="card-header text-center">{{ __('cache.cache') }}</h4>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-auto">
            <a class="btn btn-lg btn-outline-primary" href="{{ route('cache.clear', ['path' => 'cache']) }}"
               title="{{ __('cache.cache') }}">
              <span class="fas fa-trash" title="{{ __('common.action.clear') }}"></span>
              {{ __('common.action.delete') }}
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <h4 class="card-header text-center">{{ __('cache.sessions') }}</h4>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-auto">
            <a class="btn btn-lg btn-outline-primary" href="{{ route('cache.clear', ['path' => 'sessions']) }}"
               title="{{ __('cache.sessions') }}">
              <span class="fas fa-trash" title="{{ __('cache.sessions') }}"></span>
              {{ __('cache.sessions') }}
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <h4 class="card-header text-center">{{ __('cache.views') }}</h4>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-auto">
            <a class="btn btn-lg btn-outline-primary" href="{{ route('cache.clear', ['path' => 'views']) }}"
               title="{{ __('cache.views') }}">
              <span class="fas fa-trash" title="{{ __('cache.views') }}"></span>
              {{ __('cache.views') }}
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
