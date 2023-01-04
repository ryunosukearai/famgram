                    @forelse($post->comments->take(3) as $comment)
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
                        @if($post->comments->count() > 3)
                                <li class="list-group-item border-0 p-0 mb-2">
                                    <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none">
                                        View all {{$post->comments->count()}} comments
                                    </a>
                                </li>
                        @endif

                        <form action="{{ route('comment.store')}}" method="post">
                        @csrf

                            {{--button --}}
                            <div class="input-group mb-3"> 
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <input type="text" name="comment" class="form-control" placeholder="Add a comment" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary" type="submit">save</button>
                            </div>
                        </form>
