@extends('layouts.app')

@section('content')

    <div class="row gx-5">
        <div class="col-8">
            @forelse ($all_posts as $post)
                <div class="card mb-4">
                    <div class="card-header bg-white py-3">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <a href="{{ route('profile.show', $post->user->id) }}">
                                    @if ($post->user->avatar)
                                        <img src="{{ asset('/storage/avatars/' . $post->user->avatar) }}"
                                            alt="{{ $post->user->avatar }}" class="rounded-circle avatar-sm">
                                    @else
                                        <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                    @endif
                                </a>
                            </div>
                            <div class="col ps-0">
                                <a href="{{ route('profile.show', $post->user->id) }}"
                                    class="text-decoration-none text-dark">{{ $post->user->name }}</a>
                            </div>
                            <div class="col-auto">
                                <div class="dropdown">
                                    <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>

                                    {{-- If you are the owner of the post, you can edit or delete this post. --}}
                                    @if (Auth::user()->id == $post->user_id)
                                        <div class="dropdown-menu">
                                            <a href="{{ route('post.edit', $post->id) }}" class="dropdown-item">
                                                <i class="fa-regular fa-pen-to-square"></i> Edit
                                            </a>

                                            <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                                data-bs-target="#delete-post-{{ $post->id }}">
                                                <i class="fa-regular fa-trash-can"></i> Delete
                                            </button>
                                        </div>
                                        @include('users.posts.contents.modals.delete')
                                    @else
                                        {{-- If you are NOT the owner of the post, show an Unfollow button. To be discussed soon. --}}
                                        <div class="dropdown-menu">
                                            @if ($post->user->isFollowed())
                                                <form action="{{ route('follow.destroy', $post->user->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="dropdown-item text-danger">Unfollow</button>
                                                </form>
                                            @else
                                                <form action="{{ route('follow.store') }}" method="post">
                                                    @csrf

                                                    <input type="hidden" name="following_id" value="{{ $post->user->id }}">
                                                    <button type="submit"
                                                        class="dropdown-item text-primary">Follow</button>
                                                </form>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container p-0">
                        {{-- {{ storage->images  }} --}}
                        <a href="{{ route('post.show', $post->id) }}">
                            <img src="{{ asset('/storage/images/' . $post->image) }}" alt="{{ $post->image }}"
                                class="w-100">
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">


                            <div class="col-auto">
                                {{-- like button --}}
                                @include('users.posts.like')


                            </div>
                            <div class="col-auto px-0">

                                {{-- like counter --}}
                                <span>{{ $post->likes->count() }}</span>

                            </div>

                            <div class="col text-end">
                                {{-- categories selected --}}
                                @foreach ($post->categoryPost as $category_post)
                                    <div class="badge bg-secondary bg-opacity-50">
                                        {{ $category_post->category->name }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        {{-- description of the post and date --}}
                        <a href="#" class="text-decoration-none text-dark">
                            {{ $post->user->name }}
                        </a> &nbsp;
                        <p class="d-inline fw-light">{{ $post->description }}</p>
                        <p class="text-muted xsmall">{{ $post->created_at->diffForHumans() }}</p>

                        <hr>
                        {{-- comments here --}}
                        @include('users.posts.comment')

                    </div>
                </div>
            @empty
                {{-- If the site doesn't have any posts yet. --}}
                <div class="text-center">
                    <h2>Share Photos</h2>
                    <p class="text-muted">When you share photos, they'll appear on ypur profile.</p>
                    <a href="{{ route('post.create') }}" class="text-decoration-none">Share your first photo.</a>
                </div>
            @endforelse
        </div>

        {{-- Suggestion part right side --}}
        <div class="col-4">

            {{-- Profile Overview --}}
            <div class="row align-items-center mb-5 bg-white shadow-sm rounded-3 py-3">
                <div class="col-auto">
                    <a href="{{ route('profile.show', Auth::user()->id) }}">
                        @if (Auth::user()->avatar)
                            <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}"
                                alt="{{ Auth::user()->avatar }}" class="rounded-circle avatar-md">
                        @else
                            <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                        @endif
                    </a>
                </div>
                <div class="col ps-0">
                    <a href="{{ route('profile.show', Auth::user()->id) }}"
                        class="text-decoration-none text-dark fw-bold">{{ Auth::user()->name }}</a>
                    <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                </div>
            </div>

            {{-- Suggestions --}}
            @if ($suggested_users)
                <div class="row">
                    <div class="col-auto">
                        <p class="fw-bold text-secondary">Suggestions for you</p>
                    </div>
                    <div class="col text-end text-primary">
                        <a href="#" class="fw-bold text-dark text-decoration-none">
                            See all
                        </a>
                    </div>
                </div>
                @foreach ($suggested_users as $user)
                    <div class="row align-items-center mv-3">
                        <div class="col-auto">
                            <a href="">
                                @if ($user->avatar)
                                    <img src="{{ asset('/storage/avatars/' . $user->avatar) }}" alt=""
                                        class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>
                        <div class="col ps-0 text-truncate">
                            <a href="#" class="text-decoration-none text-dark fw-bold">
                                {{ $user->name }}
                            </a>
                        </div>
                        <div class="col-auto">
                            <form action="{{ route('follow.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="following_id" value="{{ $user->id }}">
                                <button type="submit"
                                    class="border-0 bg-transparent p-0 text-primary btn-sm">Follow</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>



@endsection
