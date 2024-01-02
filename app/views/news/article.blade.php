@extends('base')

@section('title', 'News '.$news_article->getId())

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <article>
                    <header>
                        <h1 class="display-4">{{ $news_article->getTitle() }}</h1>
                        <p>Posted on: {{ $news_article->getCreatedAt()->format('F j, Y') }}</p>
                    </header>
                    <section class="article-content">
                        {!! $news_article->getContent() !!}
                    </section>
                </article>
            </div>
        </div>
    </div>
@endsection