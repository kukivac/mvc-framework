@extends('base')

@section('title', 'News')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h2 class="mb-4">News</h2> {{-- Articles heading --}}
                @if($logged_in_user && $is_admin)
                    <a href="{{getLink("/news/add")}}" class="btn btn-outline-primary">Add news</a>
                @endif
            </div>
            @foreach ($news_articles as $news_article)
                <div class="col-md-4 mb-4 news-article-card" article-id="{{$news_article->getId()}}">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $news_article->getTitle() }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $news_article->getCreatedAt()->format('F j, Y') }}</h6>
                            <a href="{{getLink("/articles?id=".$news_article->getId())}}" class="btn btn-outline-primary">Read More</a>
                            @if($is_admin)
                                <button class="btn btn-outline-danger delete-news-article-button" article-id="{{$news_article->getId()}}">Delete</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection