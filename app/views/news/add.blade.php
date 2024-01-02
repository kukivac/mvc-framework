@extends('base')

@section('title', 'Add Article')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Create New News Article</h2>

        <form id="add-news-article-form" method="POST">
            <div class="form-group mb-3">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="form-group mb-3">
                <label for="content">Content</label>
                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
    </div>
@endsection