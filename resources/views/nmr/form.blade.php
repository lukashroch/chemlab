@extends('app')

@section('title', trans('nmr.new'))

@section('content')
  <div class="card">
    @component('resource.header', ['resource' => 'nmr', 'item' => $nmr, 'actions' => []])
      <li class="nav-item">
        <a class="nav-link active" href="#info" data-toggle="tab"
           role="tab">{{ trans('nmr.new') }}</a>
      </li>
    @endcomponent

    <div class="tab-content">
      <div class="tab-pane active" id="info" role="tabpanel">
        <div class="card-body">
          {{ Form::model($nmr, ['route' => ['nmr.store'], 'enctype' => 'multipart/form-data']) }}
          <div class="form-group form-row">
            {{ Form::label('file', trans('nmr.file'), ['class' => 'col-sm-3 col-md-2 col-form-label']) }}
            <div class="col-sm-9 col-md-6 col-lg-4">
              <label class="custom-file">
                <input type="file" name="file" class="custom-file-input" accept="application/zip">
                <span class="custom-file-control"></span>
              </label>
            </div>
            @includeWhen($errors->has('file'), 'partials.error', ['entry' => 'file'])
          </div>
          <div class="form-group form-row">
            {{ Form::label('user_id', trans('user.title'), ['class' => 'col-sm-3 col-md-2 col-form-label']) }}
            <div class="col-sm-9 col-md-6 col-lg-4">
              <div class="input-group">
                <div class="input-group-addon"><span class="fas fa-user-index fa-fw"></span></div>
                {{ Form::select('user_id', $users, null, ['id' => 'user_id', 'class' => 'form-control selectpicker show-tick']) }}
              </div>
              @includeWhen($errors->has('user_id'), 'partials.error', ['entry' => 'user_id'])
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
