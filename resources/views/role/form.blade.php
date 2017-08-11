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
            <a class="nav-link" href="#perms" data-toggle="tab" role="tab">{{ trans('role.perms') }}</a>
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
              <div class="form-group row">
                {{ Form::label('name', trans('role.name.internal'), ['class' => 'col-sm-3 col-lg-2 col-form-label']) }}
                <div class="col-sm-9 col-md-6 col-lg-4">
                  @if (isset($role->id))
                    <p class="form-control-static">{{ $role->name }}</p>{{ Form::hidden('id') }}
                  @else
                    {{ Form::input('text', 'name', null, ['class' => 'form-control due', 'placeholder' => trans('role.name.internal')]) }}
                  @endif
                </div>
              </div>
              <div class="form-group row">
                {{ Form::label('display_name', trans('role.name'), ['class' => 'col-sm-3 col-lg-2 col-form-label']) }}
                <div class="col-sm-9 col-md-6 col-lg-4">
                  {{ Form::input('text', 'display_name', null, ['class' => 'form-control due', 'placeholder' => trans('role.name')]) }}
                </div>
              </div>
              <div class="form-group row">
                {{ Form::label('description', trans('role.description'), ['class' => 'col-sm-3 col-lg-2 col-form-label']) }}
                <div class="col-sm-9 col-md-6 col-lg-4">
                  {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '4', 'placeholder' => trans('role.description')]) }}
                </div>
              </div>
              <div class="form-group row">
                <div class="col-auto mx-auto">{{ HtmlEx::icon('common.save') }}</div>
              </div>
              {{ Form::close() }}
            </div>
          </div>
          <div class="tab-pane" id="perms" role="tabpanel">
            <div class="row">
              @if (isset($role->id))
                <div class="col-md-6 pr-0">
                  <table class="table table-hover assigned"
                         data-url="{{ route('role.perm.detach', ['role' => $role->id, 'perm' => 'ph']) }}">
                    <thead>
                    <tr class="table-success">
                      <th>{{ trans('role.perms.assigned') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($role->perms->sortBy('display_name') as $perm)
                      @include('role.partials.perm', ['perm' => $perm, 'type' => 'assigned'])
                    @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="col-md-6 pl-0">
                  <table class="table table-hover not-assigned"
                         data-url="{{ route('role.perm.attach', ['role' => $role->id, 'perm' => 'ph']) }}">
                    <thead>
                    <tr class="table-danger">
                      <th>{{ trans('role.perms.not-assigned') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($perms as $perm)
                      @include('role.partials.perm', ['perm' => $perm, 'type' => 'not-assigned'])
                    @endforeach
                    </tbody>
                  </table>
                </div>
              @else
                <div class="col-md-12">
                  <div class="card-body">{{ trans('role.perms.header') }}</div>
                </div>
              @endif
            </div>
          </div>
          <div class="tab-pane" id="stores" role="tabpanel">
            <div class="row">
              @if (isset($role->id))
                <div class="col-md-6 pr-0">
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
                <div class="col-md-6 pl-0">
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
