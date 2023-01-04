@extends('layouts.app')

@section('title', 'Show post')

@section('content')
    <div class="row border shadow">
        <div class="col p-0 border-end">
            <img src="{{ asset('/storage/images/' . $post->image) }}" alt="{{ $post->image }}" class="w-100">
        </div>
        <div class="col-4 px-0 bg-white">
            <div class="card border-0">
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <a href="#">
                                @if ($post->user->avatar)
                                    <img src="#" alt="{{ $post->user->avatar }}" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>
                        <div class="col ps-0">
                            <a href="#" class="text-decoration-none text-dark">{{ $post->user->name }}</a>
                        </div>
                        <div class="col-auto">
                            <div class="dropdown">
                                <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>

                                {{-- If you are the owner of the post, you can edit or delete this post. --}}
                                @if (Auth::user()->id == $post->user_id)
                                    <div class="dropdown-menu">
                                        <a href="{{ route('post.edit', $post->id)}}" class="dropdown-item">
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
                                        <form action="#" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <button class="dropdown-item text-danger">Unfollow</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body w-100">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            {{-- like button --}}
                            <form action="" method="post">
                                @csrf
                                <button class="btn btn-sm shadow-none p-0">
                                    <i class="fa-regular fa-heart"></i>
                                </button>
                            </form>
                        </div>
                        <div class="col-auto px-0">
                            {{-- like counter --}}
                            <span>3</span>
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
                        @forelse($post->comments as $comment)
                            <div class="container mb-2">
                                <a href="#" class="text-decoration-none text-dark">
                                    {{ $comment->user->name }} :
                                </a>
                                &nbsp;

                                <p class="d-inline fw-bold">{{ $comment->comment }}</p>

                                    <div class="col">
                                        @method('DELETE')
                                        <form action="{{ route('comment.destroy', $comment->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <span class="text-muted xsmall">
                                                {{ $comment->created_at->diffForHumans()}}
                                            </span>
                                            &middot;
                                            @if(Auth::user()->id === $comment->user->id)
                                                <button type="submit" class="border-0 bg-transparent text-danger p-0 xsmall">Delete</button>
                                            @endif
                                        </form>
                                    </div>

                            </div>
                        @empty
                                <div class="text-center">
                                    <p>no comment</p>
                                </div>
                        @endforelse
                        
                        <form action="{{ route('comment.store')}}" method="post">
                        @csrf

                            {{--button --}}
                            <div class="input-group mb-3">
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <input type="text" name="comment" class="form-control" placeholder="Add a comment" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary" type="submit">save</button>
                            </div>
                        </form>


                </div>
            </div>
        </div>
    </div>
@endsection
