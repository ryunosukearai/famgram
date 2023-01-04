@extends('layouts.app')

@section('title', 'Admin: Categories')

@section('content')

    <div class="container mb-4">
        <form action="{{ route('admin.categories.store')}}" method="post">
            @csrf
        <h2 class="form-label">Make Category</h2>
            <div class="row">
                {{-- <input type="hidden" name="id" id="id"> --}}
                <div class="col-10">
                    <input type="text" name="name" class="form-control bg-white" placeholder="Add new category">
                </div>
                <div class="col-2">
                    <button class="btn btn-warning form-control">Make</button>
                </div>
            </div>
        </form>
    </div>

    <table class="table table-hover align-middle bg-white border text-secondary">
        <thead class="small table-warning text-secondary">
            <tr>
                <th> </th>
                <th> </th>
                <th>CATEGORY</th>
                <th>NAMED BY</th>
                <th>CREATED AT</th>
                <th>STATUS</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($all_categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>
                        {{-- @if ($category->image)
                        <img src="{{ asset('/storage/images/' . $category->image) }}" alt="{{ $post->image }}"
                            class=" d-block mx-auto avatar-md" style="height: 100px; width:100px">
                    @else
                        <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                    @endif --}}
                    <i class="fa-solid fa-circle text-secondary icon-md"></i>
                    </td>
                    <td class="fw-bold">{{ $category->name}}</td>
                    <td></td>
                    <td>{{ $category->created_at}}</td>
                    <td>
                        <i class="fa-solid fa-circle text-success"></i>&nbsp; apply
                    </td>
                    <td>
                        {{-- Do not show the ellipsis if you are the Auth user --}}
                        {{-- @if (Auth::category()->id == $user->id) --}}
                            <div class="dropdown">
                                <button class="btn btn-sm" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>

                                <div class="dropdown-menu">
                                    <button class="dropdown-item btn text-danger" data-bs-toggle="modal"
                                    data-bs-target="#delete-category-{{ $category->id }}">
                                        <i class="fa-solid fa-post-slash"></i> Delete {{ $category->name }}
                                    </button>
                                </div>
                            </div>
                        {{-- @endif --}}
                        @include('admin.categories.modal.delete')

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $all_categories->links() }}

@endsection
