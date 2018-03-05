@extends('app')

@section('title-content')
  {{ trans('team.title') }} | {{ $team->display_name or trans('team.new') }}
@endsection

@section('content')
  @component('resource.nav', isset($team->id) ? ['module' => 'team', 'action' => 'edit']
  : ['module' => 'team', 'action' => 'create'])
    <li class="breadcrumb-item">{{ isset($team->id) ? $team->display_name : trans('team.new') }}</li>
  @endcomponent

  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        @component('resource.header', ['module' => 'team', 'item' => $team, 'actions' => isset($team->id) ? ['show', 'delete'] : []])
          <li class="nav-item">
            <a class="nav-link active" href="#info" data-toggle="tab" role="tab">
              {{ $team->name ? trans('common.info') : trans('team.new') }}
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#users" data-toggle="tab" role="tab">{{ trans('team.users') }}</a>
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
                    <p class="form-control-plaintext">{{ $team->name }}</p>{{ Form::hidden('id') }}
                  @else
                    {{ Form::input('text', 'name', null, ['class' => 'form-control due', 'placeholder' => trans('team.name.internal')]) }}
                  @endif
                </div>
              </div>
              <div class="form-group form-row">
                {{ Form::label('display_name', trans('team.name'), ['class' => 'col-md-3 col-form-label']) }}
                <div class="col-md-9 col-lg-6">
                  {{ Form::input('text', 'display_name', null, ['class' => 'form-control due', 'placeholder' => trans('team.name')]) }}
                </div>
              </div>
              <div class="form-group form-row">
                {{ Form::label('description', trans('team.description'), ['class' => 'col-md-3 col-form-label']) }}
                <div class="col-md-9 col-lg-6">
                  {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '4', 'placeholder' => trans('team.description')]) }}
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
          <div class="tab-pane" id="users" role="tabpanel">
            <div class="row">
              @if (isset($team->id))
                <div class="col-md-6 pr-md-0">
                  <table class="table table-hover assigned"
                         data-url="{{ route('team.user.detach', ['team' => $team->id, 'user' => 'ph']) }}">
                    <thead>
                    <tr class="table-success">
                      <th>{{ trans('team.users.assigned') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($team->users->sortBy('name') as $user)
                      @include('team.partials.user', ['user' => $user, 'action' => 'detach'])
                    @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="col-md-6 pl-md-0">
                  <table class="table table-hover not-assigned"
                         data-url="{{ route('team.user.attach', ['team' => $team->id, 'user' => 'ph']) }}">
                    <thead>
                    <tr class="table-danger">
                      <th>{{ trans('team.users.not-assigned') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                      @include('team.partials.user', ['user' => $user, 'action' => 'attach'])
                    @endforeach
                    </tbody>
                  </table>
                </div>
              @else
                <div class="col-md-12">
                  <div class="card-body">{{ trans('team.permissions.header') }}</div>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
