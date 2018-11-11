<!DOCTYPE html>
<html lang="en">
    <head>
        @include('frontend.partials._meta')
    </head>
    <body>
        <div class="holding_page">
            <div id="app">
                <img src="{{ url('images/icons/icon-logo.svg') }}" alt="JumpButton">
                <div class="jmp-btn-frame">
                    <jump-button btn_url="#" btn_icon="{{ url('images/icons/icon-jump-dark.svg')  }}"></jump-button>
                </div>
                <h1>We're reloading, we'll be right back!</h1>
                <footer>Copyright <strong>JumpButton</strong> &copy; {{ date('Y') }}</footer>
            </div>
        </div>
        <script src="{{ mix('build/manifest.js') }}"></script>
        <script src="{{ mix("build/vendor.js") }}"></script>
        <script src="{{ mix("build/app.js") }}"></script>
        <script src="{{ mix("build/jumpbutton.js") }}"></script>
    </body>
</html>