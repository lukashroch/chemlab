<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Lukas Hroch"/>
  <meta name="description" content="Chemical database management"/>
  <meta name="csrf-token" content="{{ csrf_token() }}"/>
  <title>@yield('title')</title>
  <link rel="icon" href="{{ asset('favicon.ico') }}"/>
  <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/styles.css')) }}"/>
</head>
<body class="hold-transition sidebar-mini" id="top">
<button id="back-top" class="btn btn-primary rounded">
  <span class="fas fa-chevron-up" title="{{ trans('common.top') }}"></span>
</button>

<div class="wrapper" role="main" id="main">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      {{--<li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('home') }}" class="nav-link">
          <span class="fas fa-home" title="{{ trans('common.home') }}"></span> {{ trans('common.home') }}
        </a>
      </li>--}}
    </ul>
  </nav>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
      <span class="fas fa-fw fa-flask ml-2"></span>
      {{ config('app.name') }}
      <span class="brand-text font-weight-light">&nbsp</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      @if(auth()->check())
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <span class="fas fa-fw fa-2x fa-user text-secondary"></span>
          </div>
          <div class="info">
            <a href="{{ route('profile.index') }}" class="d-block">{{ auth()->user()->name }}</a>
          </div>
        </div>
    @endif

    <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          @if(auth()->check())
            <li class="nav-item">
              <a href="{{ route('home') }}" class="nav-link">
                <i class="nav-icon fas fa-fw fa-home" title="{{ trans('common.home') }}"></i>
                <p>{{ trans('common.home') }}</p>
              </a>
            </li>
            @permission('chemical-show')
            <li class="nav-item">
              <a href="{{ route('chemical.index') }}" class="nav-link">
                <i class="nav-icon fas fa-fw fa-flask"></i>
                <p>{{ trans('chemical.index') }}</p>
              </a>
            </li>
            @endpermission()
            @permission('store-show')
            <li class="nav-item">
              <a href="{{ route('store.index') }}" class="nav-link">
                <i class="nav-icon fas fa-fw fa-building"></i>
                <p>{{ trans('store.index') }}</p>
              </a>
            </li>
            @endpermission()
            @permission('brand-show')
            <li class="nav-item">
              <a href="{{ route('brand.index') }}" class="nav-link">
                <i class="nav-icon fas fa-fw fa-barcode"></i>
                <p>{{ trans('brand.index') }}</p>
              </a>
            </li>
            @endpermission()
            @permission('nmr-show')
            <li class="nav-item">
              <a href="{{ route('nmr.index') }}" class="nav-link">
                <i class="nav-icon fas fa-fw fa-flask"></i>
                <p>{{ trans('nmr.index') }}</p>
              </a>
            </li>
            @endpermission()

            @permission(['user-show', 'role-show', 'permission-show', 'team-show'])
            <li class="nav-item has-treeview menu-open">
              <a href="#" class="nav-link">
                <span class="nav-icon fas fa-users-cog"></span>
                <p>User/Role/Perm
                  <span class="right fas fa-angle-left"></span>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @permission('user-show')
                <li class="nav-item">
                  <a href="{{ route('user.index') }}" class="nav-link">
                    <span class="nav-icon fas fa-fw fa-users"></span>
                    <p>{{ trans('user.index') }}</p>
                  </a>
                </li>
                @endpermission()
                @permission('role-show')
                <li class="nav-item">
                  <a href="{{ route('role.index') }}" class="nav-link">
                    <span class="nav-icon far fa-fw fa-id-badge"></span>
                    <p>{{ trans('role.index') }}</p>
                  </a>
                </li>
                @endpermission()
                @permission('permission-show')
                <li class="nav-item">
                  <a href="{{ route('permission.index') }}" class="nav-link">
                    <span class="nav-icon far fa-fw fa-eye-slash"></span>
                    <p>{{ trans('permission.index') }}</p>
                  </a>
                </li>
                @endpermission()
                @permission('team-show')
                <li class="nav-item">
                  <a href="{{ route('team.index') }}" class="nav-link">
                    <span class="nav-icon fas fa-fw fa-flag"></span>
                    <p>{{ trans('team.index') }}</p>
                  </a>
                </li>
                @endpermission()
              </ul>
            </li>
            @endpermission()

            @permission(['audits-show', 'backups-show', 'logs-show', 'cache-show'])
            <li class="nav-item has-treeview menu-open">
              <a href="#" class="nav-link">
                <span class="nav-icon fas fa-cogs"></span>
                <p>{{ trans('common.advanced') }}
                  <span class="right fas fa-angle-left"></span>
                </p>
              </a>
              <ul class="nav nav-treeview">
                {{--<li class="nav-item">
                  <a href="{{ route('admin.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-cog"></i>
                    <p>{{ trans('common.admin') }}</p>
                  </a>
                </li>--}}
                {{--@permission('audits-show')
                <li class="nav-item">
                  <a href="{{ route('audits.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-server"></i>
                    <p>{{ trans('audits.index') }}</p>
                  </a>
                </li>
                @endpermission()--}}
                @permission('backups-show')
                <li class="nav-item">
                  <a href="{{ route('backups.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-server"></i>
                    <p>{{ trans('backups.index') }}</p>
                  </a>
                </li>
                @endpermission()
                @permission('cache-show')
                <li class="nav-item">
                  <a href="{{ route('cache.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-box"></i>
                    <p>{{ trans('cache.index') }}</p>
                  </a>
                </li>
                @endpermission()
                @permission('logs-show')
                <li class="nav-item">
                  <a href="{{ route('logs.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-terminal"></i>
                    <p>{{ trans('logs.index') }}</p>
                  </a>
                </li>
                @endpermission()
              </ul>
            </li>
            @endpermission()
            <li class="nav-item mt-5 pt-2 border-top border-secondary">
              <a href="{{ route('logout') }}" class="nav-link">
                <span class="nav-icon fas fa-fw fa-user-log-out"></span>
                <p>{{ trans('common.logout') }}</p>
              </a>
            </li>
          @else
            <li class="nav-item">
              <a href="{{ route('login') }}" class="nav-link">
                <span class="nav-icon fas fa-fw fa-user-log-in"></span>
                <p>{{ trans('common.login') }}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('register') }}" class="nav-link">
                <span class="nav-icon fas fa-fw fa-user-log-in"></span>
                <p>{{ trans('common.register') }}</p>
              </a>
            </li>
          @endif
        </ul>

      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col">
            <h1 class="m-0 text-dark">@yield('title', trans('common.home'))</h1>
          </div>
          <div class="col-auto">
            @section('breadcrumbs')
              {{ Breadcrumbs::render() }}
            @show
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">

        @if (!$errors->isEmpty())
          @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible">
              <span class="fas fa-common-alert-danger" aria-hidden="true"></span>
              {{ $error }}
              <a class="close float-right"><span class="fas fa-times"></span></a>
            </div>
          @endforeach
        @endif
        {{--@includeWhen(session()->has('flash_message'), 'partials.alert', ['type' => 'success', 'text' => session()->get('flash_message')])--}}

        @yield('content')
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    &copy; 2012-{{ date('Y') }} <strong>Lukas Hroch</strong>
    | {{ link_to_route('credits', trans('common.credits')) }} All
    rights reserved.
  </footer>
</div>
<!-- ./wrapper -->
<script charset="UTF-8" type="text/javascript" src="{{ asset(mix('js/scripts.js')) }}"></script>
@includeWhen(Alert::getMessages(), 'partials.notifications')
@stack('scripts')
</body>
</html>
