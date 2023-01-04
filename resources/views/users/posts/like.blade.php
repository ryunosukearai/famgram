@if ($post->isLiked())
    <form action="{{ route('like.destroy', $post->id) }}" method="post">
        @csrf
        @method('DELETE') 

        <button type="submit" class="btn btn-sm shadow-none p-0">
            <i class="fa-solid fa-heart text-danger"></i>
        </button>

    </form>
@else
    <form action="{{ route('like.store', $post->id) }}" method="post">
        @csrf

        <input type="hidden" name="post_id" value="{{ $post->id }}">

        <button type="submit" class="btn btn-sm shadow-none p-0">
            <i class="fa-regular fa-heart"></i>
        </button>

    </form>
@endif


{{-- <button type="submit" class="btn btn-sm shadow-none p-0" name="likemark">
    <i class="fa-solid fa-heart text-danger"></i>
</button> --}}
