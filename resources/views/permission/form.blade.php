@extends('app')

@section('title-content')
  {{ trans('permission.title') }} | {{ $permission->display_name or trans('permission.new') }}
@endsection

@section('content')
  @component('resource.nav', isset($permission->id) ? ['module' => 'permission', 'action' => 'edit']
  : ['module' => 'permission', 'action' => 'create'])
    <li class="breadcrumb-item">{{ isset($permission->id) ? $permission->display_name : trans('permission.new') }}</li>
  @endcomponent

  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        @component('resource.header', ['module' => 'permission', 'item' => $permission, 'actions' => isset($permission->id) ? ['show', 'delete'] : []])
          <li class="nav-item">
            <a class="nav-link active" href="#info" data-toggle="tab"
               role="tab">{{ $permission->name ? trans('common.info') : trans('permission.new') }}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#roles" data-toggle="tab" role="tab">{{ trans('role.index') }}</a>
          </li>
        @endcomponent
        <div class="tab-content">
          <div class="tab-pane active" id="info" role="tabpanel">
            <div class="card-body">
              {{ Form::model($permission, isset($permission->id) ? ['method' => 'PATCH', 'route' => ['permission.update', $permission->id]]
              : ['route' => ['permission.store']]) }}
              <div class="form-group form-row">
                {{ Form::label('name', trans('permission.name.internal'), ['class' => 'col-sm-3 col-form-label']) }}
                <div class="col-sm-9 col-lg-6">
                  @if (isset($permission->id))
                    <p class="form-control-static">{{ $permission->name }}</p>{{ Form::hidden('id') }}
                  @else
                    {{ Form::input('text', 'name', null, ['class' => 'form-control due', 'placeholder' => trans('permission.name.internal')]) }}
                  @endif
                </div>
              </div>
              <div class="form-group form-row">
                {{ Form::label('display_name', trans('permission.name'), ['class' => 'col-md-3 col-form-label']) }}
                <div class="col-md-9 col-lg-6">
                  {{ Form::input('text', 'display_name', null, ['class' => 'form-control due', 'placeholder' => trans('permission.name')]) }}
                </div>
              </div>
              <div class="form-group form-row">
                {{ Form::label('description', trans('permission.description'), ['class' => 'col-md-3 col-form-label']) }}
                <div class="col-md-9 col-lg-6">
                  {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '4', 'placeholder' => trans('permission.description')]) }}
                </div>
              </div>
              <div class="form-group form-row justify-content-center">
                <div class="col-auto">{{ HtmlEx::icon('common.save') }}</div>
              </div>
              {{ Form::close() }}
            </div>
          </div>
          <div class="tab-pane" id="roles" role="tabpanel">
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
