@extends('layouts.app')

@section('title', 'Create post')

@section('content')

<form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="category" class="fw-bold form-label d-block">
            Category <span class="text-muted fw-normal">(Up to 3)</span>
        </label>
        @foreach($all_categories as $category)
            <div class="form-check form-check-inline">
                <input class="form-check-input" name="category[]" type="checkbox" id="{{ $category->name }}" value="{{ $category->id }}">
                <label class="form-check-label" for="{{ $category->name }}">{{ $category->name }}</label>
            </div>
        @endforeach
        @error('category')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label fw-bold">Description</label>
        <textarea name="description" id="description" class="form-control" rows="3" placeholder="What's on your mind">{{ old('description') }}</textarea>
        @error('description')
            <p class="text-danger small">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-4">
        <label for="image" class="form-label fw-bold">Image</label>
        <input type="file" name="image" id="image" class="form-control">
        <div class="form-text">
            Acceptable formats: jpeg, jpg, png, gif only <br>
            Max file size is 1048kb
        </div>
        @error('image')
            <p class="text-danger small">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary fw-bold px-5">Post</button>

</form>


{{-- <div class="row justify-content-center">
    <p>Category (Up to 3)</p>

    <form action="{{ route('post.store') }}" method="post">
        @csrf

        @foreach ( $all_categories as $category)
        <div class="form-check form-check-inline mb-2">
            <input class="form-check-input" type="checkbox" id="{{ $category->id }}" value="{{ $category->id }}">
            <label class="form-check-label" for="{{ $category->id }}">{{ $category->name }}</label>
        </div>
        @endforeach


        <textarea  class="form-control" name="description" id="description" cols="50" rows="3" placeholder="Whats on your mind"></textarea>

        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input class="form-control" type="file" id="image">
            <p>Acceptable formats: jpeg, jpg, png, gif only
            <br>Max file size is 1048kb</p>
        </div>

        <button type="submit" class="btn btn-primary fw-bold px-5">Post</button>

    </form>

</div> --}}

@endsection
