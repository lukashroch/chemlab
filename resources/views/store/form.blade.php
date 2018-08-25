@extends('app')

@section('title')
  {{ $store->name ?? trans('store.new') }}
@endsection

@section('content')
  <div class="card">
    @component('resource.header', ['resource' => 'store', 'item' => $store, 'actions' => isset($store->id) ? ['show', 'delete'] : []])
      <li class="nav-item">
        <a class="nav-link active" href="#info" data-toggle="tab"
           role="tab">{{ $store->name ? trans('common.info') : trans('store.new') }}</a>
      </li>
    @endcomponent
    <div class="tab-content">
      <div class="tab-pane active" id="info" role="tabpanel">
        <div class="card-body">
          {{ Form::model($store, isset($store->id) ? ['method' => 'PATCH', 'route' => ['store.update', $store->id]]
          : ['route' => ['store.store']]) }}
          <div class="form-group form-row">
            {{ Form::label('name', trans('store.name'), ['class' => 'col-md-2 col-form-label']) }}
            <div class="col-md-10 col-lg-6">
              {{ Form::input('text', 'name', null, ['class' => 'form-control due', 'placeholder' => trans('store.name')]) }}
              @includeWhen($errors->has('name'), 'partials.error', ['entry' => 'name'])
            </div>
          </div>
          <div class="form-group form-row">
            {{ Form::label('abbr_name', trans('store.abbr_name'), ['class' => 'col-md-2 col-form-label']) }}
            <div class="col-md-10 col-lg-6">
              {{ Form::input('text', 'abbr_name', null, ['class' => 'form-control', 'placeholder' => trans('store.abbr_name')]) }}
              @includeWhen($errors->has('abbr_name'), 'partials.error', ['entry' => 'abbr_name'])
            </div>
          </div>
          <div class="form-group form-row">
            {{ Form::label('parent_id', trans('store.parent'), ['class' => 'col-md-2 col-form-label']) }}
            <div class="col-md-10 col-lg-6">
              {{ Form::select('parent_id', $stores, null, ['class' => 'form-control selectpicker show-tick']) }}
              @includeWhen($errors->has('parent_id'), 'partials.error', ['entry' => 'parent_id'])
            </div>
          </div>
          <div class="form-group form-row">
            {{ Form::label('team_id', trans('team.title'), ['class' => 'col-md-2 col-form-label']) }}
            <div class="col-md-10 col-lg-6">
              {{ Form::select('team_id', $teams, null, ['class' => 'form-control selectpicker show-tick']) }}
              @includeWhen($errors->has('team_id'), 'partials.error', ['entry' => 'team_id'])
            </div>
          </div>
          <div class="form-group form-row">
            {{ Form::label(null, trans('store.temp'), ['class' => 'col-md-2 col-form-label']) }}
            <div class="col col-lg-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">{{ trans('store.temp.min') }}</span>
                  {{ Form::label('store.temp.min', trans('store.temp.min'), ['class' => 'control-label sr-only']) }}
                </div>
                {{ Form::input('number', 'temp_min', null, ['id' => 'temp_min', 'class' => 'form-control', 'placeholder' => trans('store.temp.min')]) }}
                <div class="input-group-append">
                  <span class="input-group-text">°C</span>
                </div>
              </div>
              @includeWhen($errors->has('temp_min'), 'partials.error', ['entry' => 'temp_min'])
            </div>
            <div class="col col-lg-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">{{ trans('store.temp.max') }}</span>
                  {{ Form::label('store.temp.max', trans('store.temp.max'), ['class' => 'control-label sr-only']) }}
                </div>
                {{ Form::input('number', 'temp_max', null, ['id' => 'temp_max', 'class' => 'form-control', 'placeholder' => trans('store.temp.max')]) }}
                <div class="input-group-append">
                  <span class="input-group-text">°C</span>
                </div>
              </div>
              @includeWhen($errors->has('temp_max'), 'partials.error', ['entry' => 'temp_max'])
            </div>
          </div>
          <div class="form-group form-row">
            {{ Form::label('description', trans('store.description'), ['class' => 'col-md-2 col-form-label']) }}
            <div class="col-md-10 col-lg-6">
              {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '4', 'placeholder' => trans('store.description')]) }}
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
