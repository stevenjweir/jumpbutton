<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="“google”" content="“notranslate”">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
<link rel="manifest" href="/favicon/site.webmanifest">
<link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#7100e5">
<link rel="shortcut icon" href="/favicon/favicon.ico">
<meta name="msapplication-TileColor" content="#7100e5">
<meta name="msapplication-config" content="/favicon/browserconfig.xml">
<meta name="theme-color" content="{{ (Auth::check()) ? Auth::user()->theme->hex : '#7100e5' }}">

<link href="https://fonts.googleapis.com/css?family=Rubik:400,500,700,900" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<title>JumpButton{{ (isset($page_title)) ? ' :: ' . $page_title : '' }}</title>

{{--Analytics--}}
@include('frontend.partials._analytics')

{{--Jumpbutton Styling--}}
<link href="{{ mix('build/vendor.css') }}" rel="stylesheet">
<link href="{{ mix('build/jumpbutton.css') }}" rel="stylesheet">
@if(request()->is('admin', 'admin/*'))
    <link href="{{ mix('build/jumpbutton-admin.css') }}" rel="stylesheet">
    <script src="https://www.gstatic.com/charts/loader.js"></script>
@endif
