@extends('layouts.app')

@section('title', 'Update Profile')

@section('content')

    <div class="card text-center w-75">
        <div class="card-body my-3 mx-3">
            <h2 class="card-title text-start mb-3">Update Profile</h2>

            <form action="{{ route('profile.update', $user->id)}}" method="post">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-auto">
                        <a href="{{ route('profile.update')}}">
                            @if ($user->avatar)
                                <img src="{{ asset('/storage/avatars'. $user->avatar)}}" alt="{{ $user->avatar }}" class="rounded-circle avatar-lg">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary icon-lg"></i>
                            @endif
                        </a>
                        <p>{{ $user->id }}. {{ $user->name }}</p>
                    </div>
                    <div class="col-auto">
                        {{-- avatar/image --}}
                        <input type="file" name="avatar" id="avatar" class="form-control">
                        <div class="form-text">
                            Acceptable formats: jpeg, jpg, png, gif only <br>
                            Max file size is 1048kb
                        </div>
                        @error('image')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="container text-start">
                    <div class="mb-2">
                        <label for="name" class="form-label fw-bold">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                    </div>
                    <div class="mb-2">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="text" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                    </div>
                    <div class="mb-2">
                        <label for="introduction">Intriduction</label>
                        <textarea name="introduction" class="form-control" id="" cols="10" rows="5" placeholder="Describe your self"></textarea>
                    </div>
                    <button type="submit" class="btn btn-warning fw-bold px-5">Submit</button>
                </div>
            </form>
        </div>

    </div>


@endsection
