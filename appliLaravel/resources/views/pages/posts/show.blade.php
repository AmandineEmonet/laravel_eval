@extends('welcome')
@section('content')
    <h2>{{ $post->title }} - {{ $post->user->name }} - {{ $post->created_at->diffForHumans() }}</h2>
    <p>{{ $post->content }}</p>
    <p>{{ $post->comment }}</p>
    <a href="{{ route('posts.index') }}" class="btn btn-primary">Back to posts</a>
    @if(auth()->check() && $post->user_id === auth()->id())
        <a href="{{ route('posts.edit', $post->slug) }}" class="btn btn-info">Edit</a>
        <a href="{{ route('posts.destroy', $post->slug) }}" class="btn btn-danger">Delete</a>
    @endauth
@endsection
