@extends('layouts.app')

@section('title', 'Admin: Posts')

@section('content')

    <table class="table table-hover align-middle bg-white border text-secondary">
        <thead class="small table-primary text-secondary">
            <tr>
                <th> </th>
                <th> </th>
                <th>CATEGORY</th>
                <th>OWNER</th>
                <th>CREATED AT</th>
                <th>STATUS</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($all_posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>
                        @if ($post->image)
                            <img src="{{ asset('/storage/images/' . $post->image) }}" alt="{{ $post->image }}"
                                class=" d-block mx-auto avatar-md" style="height: 100px; width:100px">
                        @else
                            <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                        @endif
                    </td>
                    <td>
                        @foreach ($post->categoryPost as $category_post)
                            <div class="badge bg-secondary bg-opacity-50">
                                {{ $category_post->category->name }}
                            </div>
                        @endforeach
                    </td>
                    <td>{{ $post->user_id }}</td>
                    <td>{{ $post->created_at }}</td>
                    <td>
                        @if ($post->trashed())
                            <i class="fa-regular fa-circle text-secondary"></i>&nbsp; Hidden
                        @else
                            <i class="fa-solid fa-circle text-primary"></i>&nbsp; Visible
                        @endif
                    </td>
                    <td>
                        {{-- Do not show the ellipsis if you are the Auth user --}}
                        @if (Auth::user()->id != $post->id)
                            <div class="dropdown">
                                <button class="btn btn-sm" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>

                                @if (!$post->trashed())
                                    <div class="dropdown-menu">
                                        <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                            data-bs-target="#unvisible-post-{{ $post->id }}">
                                            <i class="fa-solid fa-eye-slash"></i> Hide Post {{ $post->id }}
                                        </button>
                                    </div>
                                @else
                                    <div class="dropdown-menu">
                                        <button class="dropdown-item text-primary" data-bs-toggle="modal"
                                            data-bs-target="#visible-post-{{ $post->id }}">
                                            <i class="fa-solid fa-eye"></i> Visible Post {{ $post->id }}
                                        </button>
                                    </div>
                                @endif
                            </div>
                            @include('admin.posts.modal.visible')
                        @endif

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $all_posts->links() }}

@endsection
