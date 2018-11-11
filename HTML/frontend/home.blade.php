@extends('layouts.app')

@section('content')

    <div class="container">

        @if($main_featured)
        <div class="row featured">
            <div class="col-sm-12 kard-col final-boss">
                <article-card :article="{{ $main_featured->toJson() }}"></article-card>
            </div>
        </div>
        @endif

        @if($featured)
        <article-cards :articles="{{ $featured->toJson() }}"></article-cards>
        @endif

        @if($articles)
        <div class="article-posts" id="articles">
            <article-posts :articles="{{ $articles->toJson() }}"></article-posts>
        </div>
        @endif

    </div>
@endsection