@extends('master')


@section('content')

<!-- Cover Image -->
<img src=" {{ asset('storage/'. $post->photo_path ) }} " alt="Cover" class="post-cover">

<!-- Post Content -->
<div class="col-md-9">
  <!-- Author -->
  <div class="author-info mb-4">
    <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Author">
    <div>
      <strong>{{ $post->user->name }}</strong><br>
      <small class="text-muted">{{ $post->created_at->format("F D, Y") }}</small>
    </div>
  </div>

  <!-- Title -->
  <h1 class="post-title mb-4"> {{ $post->title }} </h1>
  

  <!-- Post Body -->
  <div class="post-body"> {!! $post->content !!} </div>

  <!-- Post Body -->
  @guest
   <div class="alert alert-info">
    Please <a class="fw-bold underline" href="{{ route("loginForm") }}">Login</a> to comment on this post
  </div>
  @endguest


  <div class="border p-3">
    <form method="post" action="{{ route("comment.store") }}">
      @csrf
      <input type="hidden" value="{{ $post->id }}" name="post_id">
      <div class="mb-3 form-check">
        <h5>Leave Comment</h5>
        <textarea name="comment" class="form-control"></textarea>
        @error('comment')
          <div class="alert alert-danger my-2">{{$message}}</div>
        @enderror

        @if(session('success'))
        <div class="alert alert-success my-2">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger my-2">
            {{ session('error') }}
        </div>
        @endif

        <button type="submit" class="btn btn-primary btn-sm my-3">Send Your Comment</button>
      </div>
      
    </form>


    <div class="border">
      <h4>All Post Comments</h4>
      @if (count($post->comments) > 0)
        @foreach ($post->comments as $comment)
          <div class="p-3 bg-warning-subtle my-2">
            {{ $comment->comment }}
            
              by {{ $comment->user->name }}
            
          </div>
        @endforeach
      @endif
    </div>


    <form method="POST" action="{{ route('posts.like', $post) }}">
      @csrf
      <button type="submit" class="mb-2">
        @if(auth()->check())
        @if($post->isLikedBy(auth()->user()))
            ❤️ Liked
        @else
            🤍 Like
        @endif
    @else
        <a href="{{ route('loginForm') }}" class="text-blue-500">Login to like</a>
    @endif
      </button>
  </form>
  
  <p>{{ $post->likes()->count() }} All Post Likes</p>
  


</div>
@endsection