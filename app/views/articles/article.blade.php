@extends('base')

@section('title', 'Article '.$article->getId())

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <article>
                    <header>
                        <h1 class="display-4">{{ $article->getTitle() }}</h1>
                        <p class="lead">Author ID: {{ $article->getAuthor() }}</p>
                        <p>Posted on: {{ $article->getCreatedAt()->format('F j, Y') }}</p>
                    </header>
                    <section class="article-content">
                        {{$article->getContent()}}
                    </section>
                </article>
            </div>
        </div>
    </div>
@endsection