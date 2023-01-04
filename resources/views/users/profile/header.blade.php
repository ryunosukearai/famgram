<div class="row">
    <div class="col-4">
        {{-- icon or image--}}
        @if ($user->avatar)
            <img src="{{ asset('/storage/avatars/'.$user->avatar) }}" alt="" class="img-thumbnail rounded-circle d-block mx-auto avatar-lg">
        @else
            <i class="fa-solid fa-circle-user text-secondary d-block text-center icon-lg"></i>
        @endif
    </div>
    <div class="col-8">
        <div class="row mb-3">
            <div class="col-auto">
                {{-- name of the user--}}

                <h2 class="display-6 mb-0">
                    {{ $user->name }}
                </h2>
            </div>
            <div class="col-auto p-2">
                {{-- follow button/edit button --}}
                @if ($user->id === Auth::user()->id)
                    <a href="{{ route('profile.edit',$user->id)}}" class="btn btn-outline-secondary btn-sm fw-bold">
                        Edit Profile
                    </a>
                @else
                    <form action="#" method="post">
                        @csrf

                        <button class="btn btn-primary btn-sm fw-bold">Follow</button>
                    </form>
                @endif
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-auto">
                <a href="#" class="text-dark text-decoration-none">
                    <strong>{{ $user->posts->count() }} </strong> {{ ($user->posts->count() > 1) ? "Posts" : "Post" }}
                </a>
            </div>
            <div class="col-auto">
                <a href="#" class="text-dark text-decoration-none">
                    <strong>{{ $user->followers->count()}} </strong> Followers
                </a>
            </div>
            <div class="col-auto">
                <a href="#" class="text-dark text-decoration-none">
                    <strong>{{ $user->followed->count()}} </strong> Following
                </a>
            </div>
        </div>
        <p class="fw-bold">
            {{ $user->introduction }}
        </p>
    </div>
</div>
