@extends('app')

@section('title')
  {{ $team->display_name ?? trans('team.new') }}
@endsection

@section('content')
  <div class="card">
    @component('resource.header', ['resource' => 'team', 'item' => $team, 'actions' => isset($team->id) ? ['show', 'delete'] : []])
      <li class="nav-item">
        <a class="nav-link active" href="#info" data-toggle="tab" role="tab">
          {{ $team->name ? trans('common.info') : trans('team.new') }}
        </a>
      </li>
    @endcomponent
    <div class="tab-content">
      <div class="tab-pane active" id="info" role="tabpanel">
        <div class="card-body">
          {{ Form::model($team, isset($team->id) ? ['method' => 'PATCH', 'route' => ['team.update', $team->id]]
          : ['route' => ['team.store']]) }}
          <div class="form-group form-row">
            {{ Form::label('name', trans('team.name.internal'), ['class' => 'col-sm-3 col-form-label']) }}
            <div class="col-sm-9 col-lg-6">
              @if (isset($team->id))
                <div class="form-control-plaintext form-control-disabled">{{ $team->name }}</div>
              @else
                {{ Form::input('text', 'name', null, ['class' => 'form-control', 'placeholder' => trans('team.name.internal')]) }}
                @includeWhen($errors->has('name'), 'partials.error', ['entry' => 'name'])
              @endif
            </div>
          </div>
          <div class="form-group form-row">
            {{ Form::label('display_name', trans('team.name'), ['class' => 'col-md-3 col-form-label']) }}
            <div class="col-md-9 col-lg-6">
              {{ Form::input('text', 'display_name', null, ['class' => 'form-control', 'placeholder' => trans('team.name')]) }}
              @includeWhen($errors->has('display_name'), 'partials.error', ['entry' => 'display_name'])
            </div>
          </div>
          <div class="form-group form-row">
            {{ Form::label('description', trans('team.description'), ['class' => 'col-md-3 col-form-label']) }}
            <div class="col-md-9 col-lg-6">
              {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '4', 'placeholder' => trans('team.description')]) }}
              @includeWhen($errors->has('description'), 'partials.error', ['entry' => 'description'])
            </div>
          </div>
          <div class="form-group form-row justify-content-center">
            <div class="col-auto">
              @include('partials.actions.save')
            </div>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
@endsection
