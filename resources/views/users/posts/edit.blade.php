@extends('layouts.app')

@section('title', 'Edit post')

@section('content')

<form action="{{ route('post.update', $post->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="mb-3">
        <label for="category" class="fw-bold form-label d-block">
            Category <span class="text-muted fw-normal">(Up to 3)</span>
        </label>
        @foreach($all_categories as $category)
            @if(in_array($category->id, $selected_categories))
                <div class="form-check form-check-inline">
                    <input class="form-check-input" name="category[]" type="checkbox" id="{{ $category->name }}" value="{{ old('id',$category->id ) }}" checked>
                    <label class="form-check-label" for="{{ $category->name }}">{{ $category->name }}</label>
                </div>
            @else
                <div class="form-check form-check-inline">
                    <input class="form-check-input" name="category[]" type="checkbox" id="{{ $category->name }}" value="{{ old('id',$category->id ) }}">
                    <label class="form-check-label" for="{{ $category->name }}">{{ $category->name }}</label>
                </div>
            @endif
        @endforeach
        @error('category')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label fw-bold">Description</label>
        <textarea name="description" id="description" class="form-control" rows="3" >{{ old('description', $post->description) }}</textarea>
        @error('description')
            <p class="text-danger small">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-4">

            <img src="{{ asset('/storage/images/' . $post->image) }}" alt="{{ $post->image }}" style="height:300px; width:300px" class="img-thumbnail">

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

@endsection
