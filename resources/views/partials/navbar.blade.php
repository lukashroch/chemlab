<nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse fixed-top">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
          data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false"
          aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  {{ link_to_route('home', trans('common.title'), [], ['class' => 'navbar-brand']) }}

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    @if (Auth::check())
      <ul class="navbar-nav">
        @includeWhen(Entrust::can('chemical-show'), 'partials.navbar.item', ['type' => 'chemical.index'])
        @includeWhen(Entrust::can('compound-show'), 'partials.navbar.item', ['type' => 'compound.index'])
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
            <span class="fa fa-user" aria-hidden="true"></span> {{ Auth::user()->name }}
          </a>
          <div class="dropdown-menu" aria-labelledby="dropdown02">
            <a class="dropdown-item" href="{{ route('user.profile') }}">
              <span class="fa fa-user-profile" aria-hidden="true"></span> {{ trans('user.profile') }}
            </a>
            <a class="dropdown-item" href="{{ url('/logout') }}">
              <span class="fa fa-user-log-out" aria-hidden="true"></span> {{ trans('user.log.out') }}
            </a>
          </div>
        </li>
      </ul>
    @else
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/login') }}">
            <span class="fa fa-user-log-in" aria-hidden="true"></span> {{ trans('user.log.in') }}
          </a>
        </li>
      </ul>
    @endif
  </div>
</nav>
