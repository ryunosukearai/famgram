@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="row justify-content-center">
        <div class="col-8">
            <form action="{{ route('profile.update', $user->id)}}" method="post" class="bg-white shadow rounded-3 p-5" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <h2 class="h3 mb-3 fw-light text-muted">Update Profile</h2>

                <div class="row mb-3">
                    <div class="col-4">
                        @if ($user->avatar)
                            <img src="{{ asset('/storage/avatars/'.$user->avatar) }}" alt="" class="img-thumbnail rounded-circle d-block mx-auto avatar-lg">
                        @else
                            <i class="fa-solid fa-circlr-user text-secondary d-block text-center icon-lg"></i>
                        @endif
                    </div>
                    <div class="col-auto align-self-end">
                        <input type="file" name="avatar" class="form-control form-control-sm mt-1">
                        <div class="form-text">
                            Acceptable formats: jpeg, jpg, png, gif only <br>
                            Max file size is 1048kb
                        </div>
                        {{-- kb, mb, gb ,tb
                        bit
                        bits = 8 bit
                        bytes = 100 bytes
                        kiloybtes = 100 bites
                        megabytes = 100 kilobyts
                        gigabytes = 100 megabytes
                        terabytes = 100 giga bytes --}}
                    </div>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Name</label>
                    <input type="text" name="name" value="{{ $user->name }}" id="name" class="form-control" autofocus>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="text" name="email" id="email" value="{{ $user->email }}" class="form-control" autofocus>
                </div>
                <div class="mb-3">
                    <label for="introduction" class="form-label fw-bold">Introduction</label>
                    <textarea  class="form-control" name="introduction" id="introduction" rows="5">{{ $user->introduction }}</textarea>
                </div>

                <button type="submit" class="btn btn-warning px-5">Save</button>
            </form>
        </div>
    </div>

@endsection
