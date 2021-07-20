@extends('welcome')
@section('content')
    <div class="row">
        @auth
            <div class="col-sm-12 mb-3">
                <a href="{{ route('posts.create') }}" class="btn btn-primary">Create new Post</a>
            </div>
        @endauth
        @forelse($posts as $post)
            <div class="col-sm-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <small>{{ $post->user->name }}</small>

                        {{--faire une boucle afin de parcourir tout le contenus de tout les commentaires--}}
                        @foreach (comments as $comment )
                        {{$comment->contents->content}}
                        @endforeach

                        <p class="card-text">{{ Str::limit($post->content, 150) }}</p>
                        <small>{{ $post->updated_at->diffForHumans() }}</small>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-primary">See more</a>
                        @if(auth()->check() && $post->user_id === auth()->id())
                            <a href="{{ route('posts.edit', $post->slug) }}" class="btn btn-info">Edit</a>
                            <a href="{{ route('posts.destroy', $post->slug) }}" class="btn btn-danger">Delete</a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">No posts</h5>
                    </div>
                </div>
            </div>
        @endforelse
        {{ $posts->links() }}
    </div>
@endsection
