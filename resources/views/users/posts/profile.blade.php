@extends('layouts.app')

@section('title', 'Show Profile')

@section('content')
<div class="container text-center w-75">
    <div class="row">


        <div class="col-auto">
            <a href="#">
                @if ($user->avatar)
                    <img src="#" alt="{{ $user->avatar }}" class="rounded-circle avatar-lg">
                @else
                    <i class="fa-solid fa-circle-user text-secondary icon-lg"></i>
                @endif
            </a>
        </div>
        <div class="col-auto">
            <h1>{{ $user->name }}</h1>

                <p>Posts</p>
                <p>Follower</p>
                <p>Following</p>

        </div>
        <div class="col">
            <a href="{{ route('profile.edit', $user->id)}}" class="btn btn-outline-success">Edit Profile</a>
        </div>
    </div>
    {{-- {{ $user->id}} --}}

    {{-- posts here --}}
    <div class="row justify-content-start">
        @forelse($user->posts as $post)
        <div class="col-4 p-0">
            <a href="{{route('post.show', $post->id)}}">
                <img src="{{ asset('/storage/images/' . $post->image) }}" alt="{{ $post->image }}" class="w-100">
            </a>
        </div>
        @empty
            <div class="container my-2">
                <p>No Post</p>
            </div>
        @endforelse
    </div>

</div>

@endsection
