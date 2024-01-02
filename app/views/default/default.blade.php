@extends('base')
@section('title',$title)
@section('content')
    <!-- Hero Section -->
    <div class="jumbotron jumbotron-fluid mt-3">
        <div class="container text-center">
            <h1 class="display-4">Welcome to Insightful Reads</h1>
            <p class="lead">Explore a world of knowledge through our curated articles.</p>
        </div>
    </div>

    <!-- Featured Articles Section -->
    <section class="container">
        <div class="row">
            @foreach($articles as $article)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{$article->getTitle()}}</h5>
                            <p class="card-text">{{$article->getDescription()}}</p>
                            <a href="{{getLink("/articles?id=".$article->getId())}}" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    <section class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-4">Latest News</h2>
            <div class="row">
                @foreach($news_articles as $news_article)

                    <div class="col-md-6">
                        <div class="news-item mb-4">
                            <h3>{{$news_article->getTitle()}}</h3>
                            <p>{{$news_article->getContent()}}</p>
                            <a href="{{getLink("/news?id=".$news_article->getId())}}" class="btn btn-outline-primary">Read More</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">What Our Readers Say</h2>
            <div class="row">
                <div class="col-md-4">
                    <blockquote class="blockquote">
                        <p>"I've found Insightful Reads to be a treasure trove of knowledge. The articles are well-written and thought-provoking."</p>
                        <footer class="blockquote-footer">Jane Doe, <cite title="Source Title">Regular Reader</cite></footer>
                    </blockquote>
                </div>
                <div class="col-md-4">
                    <blockquote class="blockquote">
                        <p>"As a lifelong learner, this site has become my go-to source for insightful articles on a variety of topics."</p>
                        <footer class="blockquote-footer">John Smith, <cite title="Source Title">Enthusiast</cite></footer>
                    </blockquote>
                </div>
                <div class="col-md-4">
                    <blockquote class="blockquote">
                        <p>"Absolutely love the diversity of subjects covered here. There's always something new and interesting to read!"</p>
                        <footer class="blockquote-footer">Alex Johnson, <cite title="Source Title">Curious Mind</cite></footer>
                    </blockquote>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Subscribe Section -->
    <section class="bg-dark text-white py-5">
        <div class="container text-center">
            <h2>Stay Updated!</h2>
            <p>Subscribe to our newsletter to get the latest articles and news delivered straight to your inbox!</p>
            <form>
                <div class="d-flex flex-row justify-content-center">
                    <div class="col-auto">
                        <input type="email" class="form-control" placeholder="Enter your email">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Subscribe</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection