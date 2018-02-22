@extends('app')

@section('title-content')
  {{ trans('role.title') }} | {{ $role->display_name or trans('role.new') }}
@endsection

@section('content')
  @component('resource.nav', isset($role->id) ? ['module' => 'role', 'action' => 'edit']
  : ['module' => 'role', 'action' => 'create'])
    <li class="breadcrumb-item">{{ isset($role->id) ? $role->display_name : trans('role.new') }}</li>
  @endcomponent

  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        @component('resource.header', ['module' => 'role', 'item' => $role, 'actions' => isset($role->id) ? ['show', 'delete'] : []])
          <li class="nav-item">
            <a class="nav-link active" href="#info" data-toggle="tab" role="tab">
              {{ $role->name ? trans('common.info') : trans('role.new') }}
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#permissions" data-toggle="tab" role="tab">{{ trans('role.permissions') }}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#stores" data-toggle="tab" role="tab">{{ trans('role.stores') }}</a>
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
                    <p class="form-control-static">{{ $role->name }}</p>{{ Form::hidden('id') }}
                  @else
                    {{ Form::input('text', 'name', null, ['class' => 'form-control due', 'placeholder' => trans('role.name.internal')]) }}
                  @endif
                </div>
              </div>
              <div class="form-group form-row">
                {{ Form::label('display_name', trans('role.name'), ['class' => 'col-md-3 col-form-label']) }}
                <div class="col-md-9 col-lg-6">
                  {{ Form::input('text', 'display_name', null, ['class' => 'form-control due', 'placeholder' => trans('role.name')]) }}
                </div>
              </div>
              <div class="form-group form-row">
                {{ Form::label('description', trans('role.description'), ['class' => 'col-md-3 col-form-label']) }}
                <div class="col-md-9 col-lg-6">
                  {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '4', 'placeholder' => trans('role.description')]) }}
                </div>
              </div>
              <div class="form-group form-row justify-content-center">
                <div class="col-auto">{{ HtmlEx::icon('common.save') }}</div>
              </div>
              {{ Form::close() }}
            </div>
          </div>
          <div class="tab-pane" id="permissions" role="tabpanel">
            <div class="row">
              @if (isset($role->id))
                <div class="col-md-6 pr-md-0">
                  <table class="table table-hover assigned"
                         data-url="{{ route('role.permission.detach', ['role' => $role->id, 'permission' => 'ph']) }}">
                    <thead>
                    <tr class="table-success">
                      <th>{{ trans('role.permissions.assigned') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($role->permissions->sortBy('display_name') as $permission)
                      @include('role.partials.permission', ['permission' => $permission, 'type' => 'assigned'])
                    @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="col-md-6 pl-md-0">
                  <table class="table table-hover not-assigned"
                         data-url="{{ route('role.permission.attach', ['role' => $role->id, 'permission' => 'ph']) }}">
                    <thead>
                    <tr class="table-danger">
                      <th>{{ trans('role.permissions.not-assigned') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($permissions as $permission)
                      @include('role.partials.permission', ['permission' => $permission, 'type' => 'not-assigned'])
                    @endforeach
                    </tbody>
                  </table>
                </div>
              @else
                <div class="col-md-12">
                  <div class="card-body">{{ trans('role.permissions.header') }}</div>
                </div>
              @endif
            </div>
          </div>
          <div class="tab-pane" id="stores" role="tabpanel">
            <div class="row">
              @if (isset($role->id))
                <div class="col-md-6 pr-md-0">
                  <table class="table table-hover assigned"
                         data-url="{{ route('role.store.detach', ['role' => $role->id, 'store' => 'ph']) }}">
                    <thead>
                    <tr class="table-success">
                      <th>{{ trans('role.stores.assigned') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($role->stores->sortBy('tree_name') as $store)
                      @include('role.partials.store', ['store' => $store, 'type' => 'assigned'])
                    @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="col-md-6 pl-md-0">
                  <table class="table table-hover not-assigned"
                         data-url="{{ route('role.store.attach', ['role' => $role->id, 'store' => 'ph']) }}">
                    <thead>
                    <tr class="table-danger">
                      <th>{{ trans('role.stores.not-assigned') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($stores as $store)
                      @include('role.partials.store', ['store' => $store, 'type' => 'not-assigned'])
                    @endforeach
                    </tbody>
                  </table>
                </div>
              @else
                <div class="col-md-12">
                  <div class="card-body">{{ trans('role.stores.header') }}</div>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
