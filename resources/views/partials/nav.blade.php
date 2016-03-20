<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
              aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      {{ link_to_route('home', trans('common.title'), [], ['class' => 'navbar-brand']) }}
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      @if (Auth::check())
        <ul class="nav navbar-nav">
          @if (Entrust::can('chemical-show'))
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span
                        class="fa fa-nav-chemicals" aria-hidden="true"></span> {{ trans('common.chemicals') }} <span
                        class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li>{{ HtmlEx::icon('chemical.index') }}</li>
                <li>{{ HtmlEx::icon('chemical.recent') }}</li>
                <li>{{ HtmlEx::icon('chemical.search')}}</li>
              </ul>
            </li>
          @endif
          @if (Entrust::can('compound-show'))
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span
                        class="fa fa-nav-compounds" aria-hidden="true"></span> {{ trans('common.compounds') }} <span
                        class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li>{{ HtmlEx::icon('compound.index') }}</li>
              </ul>
            </li>
          @endif
        </ul>
        <ul class="nav navbar-nav navbar-right">
          @if (Entrust::can(['store-show', 'brand-show', 'permission-show', 'role-show', 'user-show']) || Entrust::hasRole('admin'))
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span
                        class="fa fa-nav-management" aria-hidden="true"></span> {{ trans('common.management') }} <span
                        class="caret"></span></a>
              <ul class="dropdown-menu dropdown-menu-right" role="menu">
                @if (Entrust::can('store-show') || Entrust::can('brand-show'))
                  @if (Entrust::can('brand-show'))
                    <li>{{ HtmlEx::icon('brand.index') }}</li>
                  @endif
                  @if (Entrust::can('store-show'))
                    <li>{{ HtmlEx::icon('store.index')}}</li>
                  @endif
                  <li role="presentation" class="divider"></li>
                @endif
                @if (Entrust::can('permission-show'))
                  <li>{{ HtmlEx::icon('permission.index')}}</li>
                @endif
                @if (Entrust::can('role-show'))
                  <li>{{ HtmlEx::icon('role.index')}}</li>
                @endif
                @if (Entrust::can('user-show'))
                  <li>{{ HtmlEx::icon('user.index')}}</li>
                @endif
                @if (Entrust::hasRole('admin'))
                  <li role="presentation" class="divider"></li>
                  <li>{{ HtmlEx::icon('admin.index')}}</li>
                @endif
              </ul>
            </li>
          @endif
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span
                      class="fa fa-user" aria-hidden="true"></span> {{ Auth::user()->name }} <span class="caret"></span></a>
            <ul class="dropdown-menu dropdown-menu-right" role="menu">
              <li><a href="{{ route('user.profile') }}"><span class="fa fa-user-profile"
                                                              aria-hidden="true"></span> {{ trans('user.profile') }}</a>
              </li>
              <li role="presentation" class="divider"></li>
              <li><a href="{{ url('/logout') }}"><span class="fa fa-user-log-out"
                                                       aria-hidden="true"></span> {{ trans('user.log.out') }}</a></li>
            </ul>
          </li>
        </ul>
      @else
        <ul class="nav navbar-nav navbar-right">
          <li><a href="{{ url('/login') }}"><span class="fa fa-user-log-in"
                                                  aria-hidden="true"></span> {{ trans('user.log.in') }}</a></li>
        </ul>
      @endif
    </div><!--/.nav-collapse -->
  </div>
</nav>