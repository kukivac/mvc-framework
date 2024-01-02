@extends('base')

@section('title', 'Add Article')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Create New Article</h2>

        <form id="add-article-form" method="POST">
            @csrf {{-- CSRF token for form security --}}

            <div class="form-group mb-3">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="form-group mb-3">
                <label for="description">Short Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>

            <div class="form-group mb-3">
                <label for="content">Content</label>
                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
    </div>
@endsection