@extends('app')

@section('title')
  {{ $role->display_name ?? trans('role.new') }}
@endsection

@section('content')
  <div class="card">
    @component('resource.header', ['resource' => 'role', 'item' => $role, 'actions' => isset($role->id) ? ['show', 'delete'] : []])
      <li class="nav-item">
        <a class="nav-link active" href="#info" data-toggle="tab" role="tab">
          {{ $role->name ? trans('common.info') : trans('role.new') }}
        </a>
      </li>
    @endcomponent
    <div class="tab-content">
      <div class="tab-pane active" id="info" role="tabpanel">
        <div class="card-body">
          {{ Form::model($role, isset($role->id) ? ['method' => 'PATCH', 'route' => ['role.update', $role->id]]
          : ['route' => ['role.store']]) }}
          <div class="form-group form-row">
            {{ Form::label('name', trans('role.name.internal'), ['class' => 'col-sm-3 col-form-label']) }}
            <div class="col-sm-9 col-lg-6">
              @if (isset($role->id))
                <div class="form-control-plaintext form-control-disabled">{{ $role->name }}</div>
              @else
                {{ Form::input('text', 'name', null, ['class' => 'form-control', 'placeholder' => trans('role.name.internal')]) }}
                @includeWhen($errors->has('name'), 'partials.error', ['entry' => 'name'])
              @endif
            </div>
          </div>
          <div class="form-group form-row">
            {{ Form::label('display_name', trans('role.name'), ['class' => 'col-md-3 col-form-label']) }}
            <div class="col-md-9 col-lg-6">
              {{ Form::input('text', 'display_name', null, ['class' => 'form-control', 'placeholder' => trans('role.name')]) }}
              @includeWhen($errors->has('display_name'), 'partials.error', ['entry' => 'display_name'])
            </div>
          </div>
          <div class="form-group form-row">
            {{ Form::label('description', trans('role.description'), ['class' => 'col-md-3 col-form-label']) }}
            <div class="col-md-9 col-lg-6">
              {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '4', 'placeholder' => trans('role.description')]) }}
              @includeWhen($errors->has('description'), 'partials.error', ['entry' => 'description'])
            </div>
          </div>
          <hr>
          <div class="form-group">
            {{ Form::label('permissions', trans('permission.index'), ['class' => 'col-form-label']) }}
            <div class="form-row">
              @foreach($permissions as $name => $group)
                <div class="col-md-4 px-3 mb-3">
                  <div class="border rounded p-3">
                    <h6>{{ $name == 'general' ? trans('common.misc') : trans($name.'.index') }}</h6>
                    @foreach($group as $permission)
                      <div class="custom-control custom-checkbox mb-2">
                        {{ Form::checkbox('permissions[]', $permission->id, $role->hasPermission($permission->name), ['class' => 'custom-control-input', 'id' => 'permission_'.$permission->id]) }}
                        {{ Form::label('permission_'.$permission->id, $permission->display_name, ['class' => 'custom-control-label']) }}
                      </div>
                    @endforeach
                  </div>
                  @includeWhen($errors->has('permissions'), 'partials.error', ['entry' => 'permissions'])
                </div>
              @endforeach
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
