<navbar inline-template :admin="{{ Auth::check() && Auth::user()->isAdmin() ? 'true' : 'false' }}">
    <div :class="{ 'nav-container' : true, 'power-up' : powerUp }">
        <nav class="navbar navbar-static-top navbar-jump">
            <div class="container">
                @auth
                <div v-cloak class="nav-dropdown">
                    <button class="dropdown-toggle" type="button" id="navigationMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">more_vert</i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="navigationMenu">
                        <li class="dropdown-item  {{ (request()->is('search', 'search/*')) ? 'active' : '' }} d-xs-block d-sm-none">
                            <a href="#"><i class="material-icons">search</i>Search</a>
                        </li>
                        @auth
                            <li class="dropdown-item {{ (request()->is('profile', 'profile/*')) ? 'active' : '' }}">
                                <a href="{{ route('home') }}"><i class="material-icons">person</i>{{ Auth::user()->fullName() }}</a>
                            </li>
                            <li class="dropdown-item">
                                <a href="#" class="sub-link" onclick="event.preventDefault();document.getElementById('logout-form').submit()">
                                    <i class="material-icons">exit_to_app</i>Log Out
                                </a>
                            </li>
                            <form action="{{ route('logout') }}" class="hidden" id="logout-form" method="POST">
                                {{ csrf_field() }}
                            </form>
                            @if(Auth::user()->isAdmin())
                                <li class="dropdown-divider"></li>
                                <li  class="dropdown-item  {{ (request()->is('/')) ? 'active' : '' }}">
                                    <a href="{{ route('home') }}"><i class="material-icons">dashboard</i>Frontend</a>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li  class="dropdown-item {{ (request()->is('admin')) ? 'active' : '' }}">
                                    <a href="{{ route('admin.index') }}"><i class="material-icons">settings</i>Admin</a>
                                </li>
                                <li  class="dropdown-item {{ (request()->is('admin/article', 'admin/article/*')) ? 'active' : '' }}">
                                    <a href="{{ route('admin.article.index') }}"><i class="material-icons">description</i>Articles</a>
                                </li>
                                <li  class="dropdown-item {{ (request()->is('admin/file', 'admin/file/*')) ? 'active' : '' }}">
                                    <a href="{{ route('admin.file.index') }}"><i class="material-icons">sd_storage</i>Memory Card</a>
                                </li>
                                <li  class="dropdown-item {{ (request()->is('admin/game', 'admin/game/*')) ? 'active' : '' }}">
                                    <a href="{{ route('admin.game.index') }}"><i class="material-icons">games</i>Game Library</a>
                                </li>
                                <li  class="dropdown-item {{ (request()->is('admin/user', 'admin/user/*')) ? 'active' : '' }}">
                                    <a href="{{ route('admin.user.index') }}"><i class="material-icons">people</i>Player Control</a>
                                </li>
                                <li  class="dropdown-item {{ (request()->is('admin/topic', 'admin/topic/*')) ? 'active' : '' }}">
                                    <a href="{{ route('admin.topic.index') }}"><i class="material-icons">bookmark_border</i>Topics</a>
                                </li>
                                <li  class="dropdown-item {{ (request()->is('admin/developer', 'admin/developer/*')) ? 'active' : '' }}">
                                    <a href="{{ route('admin.developer.index') }}"><i class="material-icons">code</i>Developers</a>
                                </li>
                                <li  class="dropdown-item {{ (request()->is('admin/publisher', 'admin/publisher/*')) ? 'active' : '' }}">
                                    <a href="{{ route('admin.publisher.index') }}"><i class="material-icons">account_balance</i>Publishers</a>
                                </li>
                                <li  class="dropdown-item {{ (request()->is('admin/platform', 'admin/platform/*')) ? 'active' : '' }}">
                                    <a href="{{ route('admin.platform.index') }}"><i class="material-icons">videogame_asset</i>Platforms</a>
                                </li>
                                <li  class="dropdown-item {{ (request()->is('admin/genre', 'admin/genre/*')) ? 'active' : '' }}">
                                    <a href="{{ route('admin.genre.index') }}"><i class="material-icons">style</i>Genres</a>
                                </li>
                            @endif
                        @else
                            <li class="dropdown-item {{ (request()->is('login')) ? 'active' : '' }}">
                                <a href="{{ (env('APP_ENV') == 'local') ? route('secret.login') : route('login') }}"><i class="material-icons">person</i>Login</a>
                            </li>
                            <li class="dropdown-item {{ (request()->is('register')) ? 'active' : '' }}">
                                <a href="{{ route('register') }}" class="sub-link"><i class="material-icons">person_add</i>Register</a>
                            </li>
                        @endauth
                    </ul>
                </div>
                @endauth
                <a href="{{route('home')}}" class="navbar-brand">
                    @if(Auth::check() && Auth::user()->theme_id == 5)
                        <img src="{{ url('images/icons/icon-logo-dark.svg') }}" alt="JumpButton">
                    @else
                        <img src="{{ url('images/icons/icon-logo.svg') }}" alt="JumpButton">
                    @endif
                </a>
                <div class="jmp-btn-frame">
                    <jump-button
                            btn_url="{{ route('jumpbutton') }}"
                            btn_icon="{{ url('images/icons/icon-jump-dark.svg')  }}"
                    ></jump-button>
                </div>
                @auth
                <ul v-cloak class="nav navbar-nav navbar-right">
                    <li class="nav-search">
                        <form method="GET" action="{{ route('search') }}" accept-charset="UTF-8" role="search">
                            <div class="nav-search-container">
                                <div class="nav-search-field">
                                    <input type="text" name="search" id="search" placeholder="Search..." value="{{ (isset($_GET['search'])) ? $_GET['search'] : '' }}">
                                </div>
                            </div>
                            <div class="nav-search-button">
                                <jump-button
                                        btn_url="#"
                                        btn_icon="{{ url('images/icons/icon-search.svg') }}"
                                ></jump-button>
                            </div>
                        </form>
                    </li>
                </ul>
                @endauth
            </div>
        </nav>
    </div>
</navbar>