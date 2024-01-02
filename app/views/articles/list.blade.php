@extends('base')

@section('title', 'Articles')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h2 class="mb-4">Articles</h2> {{-- Articles heading --}}
                @if($logged_in_user)
                    <a href="{{getLink("/articles/add")}}" class="btn btn-outline-primary">Add article</a>
                @endif
            </div>
            @foreach ($articles as $article)
                <div class="col-md-4 mb-4 articles-article-card" article-id="{{$article->getId()}}">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $article->getTitle() }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $article->getCreatedAt()->format('F j, Y') }}</h6>
                            <p class="card-text">{{ $article->getDescription()}}</p>
                            <a href="{{getLink("/articles?id=".$article->getId())}}" class="btn btn-outline-primary">Read More</a>
                            @if($is_admin)
                                <button class="btn btn-outline-danger delete-articles-article-button" article-id="{{$article->getId()}}">Delete</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection