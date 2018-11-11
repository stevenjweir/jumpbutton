@extends('layouts.app')

@section('content')
<article-header :header_image="{{ json_encode($article['header_image']) }}"></article-header>
<article-page :article="{{ json_encode($article) }}" :admin="{{ (Auth::check() && Auth::user()->isAdmin()) ? 'true' : 'false' }}"></article-page>
@include('frontend.article._game_pad_btns')
@endsection