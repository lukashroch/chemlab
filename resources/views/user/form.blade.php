@extends('app')

@section('title-content')
  {{ trans('user.title') }} | {{ $user->name or trans('user.new') }}
@endsection

@section('content')
  @component('resource.nav', isset($user->id) ? ['module' => 'user', 'action' => 'edit']
  : ['module' => 'user', 'action' => 'create'])
    <li class="breadcrumb-item">{{ isset($user->id) ? $user->name : trans('user.new') }}</li>
  @endcomponent

  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        @component('resource.header', ['module' => 'user', 'item' => $user, 'actions' => isset($user->id) ? ['show', 'delete'] : []])
          <li class="nav-item">
            <a class="nav-link active" href="#info" data-toggle="tab"
               role="tab">{{ $user->name ? trans('common.info') : trans('user.new') }}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#roles" data-toggle="tab" role="tab">{{ trans('role.index') }}</a>
          </li>
        @endcomponent

        <div class="tab-content">
          <div class="tab-pane active" id="info" role="tabpanel">
            <div class="card-block">
              {{ Form::model($user, isset($user->id) ? ['method' => 'PATCH', 'route' => ['user.update', $user->id]]
              : ['route' => ['user.store']]) }}
              <div class="form-group row">
                {{ Form::label('name', trans('user.name'), ['class' => 'col-sm-2 col-form-label']) }}
                <div class="col-sm-10 col-md-6 col-lg-4">
                  {{ Form::input('text', 'name', null, ['class' => 'form-control due', 'placeholder' => trans('user.name')]) }}
                </div>
              </div>
              <div class="form-group row">
                {{ Form::label('email', trans('user.email'), ['class' => 'col-sm-2 col-form-label']) }}
                <div class="col-sm-10 col-md-6 col-lg-4">
                  @if (isset($user->id))
                    <p class="form-control-static">{{ $user->email }}</p>{{ Form::hidden('id') }}
                  @else
                    {{ Form::input('email', 'email', null, ['class' => 'form-control due', 'placeholder' => trans('user.email')]) }}
                  @endif
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-auto mx-auto">{{ HtmlEx::icon('common.save') }}</div>
              </div>
              {{ Form::close() }}
            </div>
          </div>
          <div class="tab-pane" id="roles" role="tabpanel">
            <div class="row">
              @if (isset($user->id))
                <div class="col-md-6 pr-0">
                  <table class="table table-hover assigned"
                         data-url="{{ route('user.role.detach', ['user' => $user->id, 'role' => 'ph']) }}">
                    <thead>
                    <tr class="table-success">
                      <th>{{ trans('user.roles.assigned') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($user->roles->sortBy('display_name') as $role)
                      @include('user.partials.role', ['role' => $role, 'type' => 'assigned'])
                    @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="col-md-6 pl-0">
                  <table class="table table-hover not-assigned"
                         data-url="{{ route('user.role.attach', ['user' => $user->id, 'role' => 'ph']) }}">
                    <thead>
                    <tr class="table-danger">
                      <th>{{ trans('user.roles.not-assigned') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($roles as $role)
                      @include('user.partials.role', ['role' => $role, 'type' => 'not-assigned'])
                    @endforeach
                    </tbody>
                  </table>
                </div>
              @else
                <div class="col-md-12">
                  <div class="card-block">{{ trans('user.roles.header') }}</div>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
