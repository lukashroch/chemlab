<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="{{ route('home') }}">{{ trans('common.title') }}</a>
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
          data-target="#navbar" aria-controls="navbar" aria-expanded="false"
          aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbar">
    @if (Auth::check())
      <ul class="navbar-nav">
        @includeWhen(Entrust::can('chemical-show'), 'partials.navbar.item', ['type' => 'chemical.index'])
        @includeWhen(Entrust::can('nmr-show'), 'partials.navbar.item', ['type' => 'nmr.index'])
      </ul>
      <ul class="navbar-nav ml-auto">
        @if (Entrust::can(['store-show', 'brand-show', 'permission-show', 'role-show', 'user-show']) || Entrust::hasRole('admin'))
          <li class="nav-item dropdown dropdown-menu-right">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
              <span class="fa fa-nav-management" aria-hidden="true"></span> {{ trans('common.management') }}
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown01">
              @if (Entrust::can('store-show') || Entrust::can('brand-show'))
                @includeWhen(Entrust::can('brand-show'), 'partials.navbar.dropdown-item', ['type' => 'brand.index'])
                @includeWhen(Entrust::can('store-show'), 'partials.navbar.dropdown-item', ['type' => 'store.index'])
              @endif
              @includeWhen(Entrust::can('permission-show'), 'partials.navbar.dropdown-item', ['type' => 'permission.index'])
              @includeWhen(Entrust::can('role-show'), 'partials.navbar.dropdown-item', ['type' => 'role.index'])
              @includeWhen(Entrust::can('user-show'), 'partials.navbar.dropdown-item', ['type' => 'user.index'])
              @includeWhen(Entrust::hasRole('admin'), 'partials.navbar.dropdown-item', ['type' => 'admin.index'])
            </div>
          </li>
        @endif
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown02" data-toggle="dropdown"
             aria-haspopup="true" aria-expanded="false">
            <span class="fa fa-user" aria-hidden="true"></span> {{ auth()->user()->name }}
          </a>
          <div class="dropdown-menu" aria-labelledby="dropdown02">
            <a class="dropdown-item" href="{{ route('profile.index') }}">
              <span class="fa fa-profile" aria-hidden="true"></span> {{ trans('profile.index') }}
            </a>
            <a class="dropdown-item" href="{{ route('logout') }}">
              <span class="fa fa-user-log-out" aria-hidden="true"></span> {{ trans('user.log.out') }}
            </a>
          </div>
        </li>
      </ul>
    @else
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}">
            <span class="fa fa-user-log-in" aria-hidden="true"></span> {{ trans('user.log.in') }}
          </a>
        </li>
      </ul>
    @endif
  </div>
</nav>
