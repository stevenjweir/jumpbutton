<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include('frontend.partials._meta')
    </head>
    <body class="{{ (Auth::check()) ? Auth::user()->theme->class : '' }}">
        <div id="app">
            @include('layouts._nav')
            @if(session()->has('message.level'))
                <div class="alert-container">
                    <div class="alert alert-{{ session('message.level') }}">
                        {!! session('message.content') !!}
                    </div>
                </div>
            @endif

            @yield('content')
            <footer>Copyright <strong>JumpButton</strong> &copy; {{ date('Y') }}</footer>
        </div>
        <script src="{{ mix('build/manifest.js') }}"></script>
        <script src="{{ mix("build/vendor.js") }}"></script>
        <script src="{{ mix("build/app.js") }}"></script>
        <script src="{{ mix("build/jumpbutton.js") }}"></script>
        @if(request()->is('admin', 'admin/*'))
            <script src="{{ mix("build/jumpbutton-admin.js") }}"></script>
        @endif
        @yield('scripts')
    </body>
</html>