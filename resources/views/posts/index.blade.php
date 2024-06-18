<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Blog page</title>
</head>

<body>
    <h1>Welcome to the programming blog</h1>

    @auth
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Create New Blog Post</a>
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button type="submit">
                {{ __('Logout') }}
            </button>
        </form>
    @endauth

    @if (!Auth::check())
        <a href="{{ route('login') }}">Login</a>
    @endif

    @foreach ($posts as $post)
        <h2><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></h2>
        <p>An article by <em>{{$post->author->name}}</em> published on {{$post->created_at->format('d.m.y')}}

            @if(isset($categories[$post->category_id]))
                in category {{ $categories[$post->category_id]->title }}
            @else
                in an undefined category
            @endif
        </p>
        <p>{{ $post->body }}</p>

        @can('update-post', $post)
            <p><form method="POST" action="{{ route('posts.destroy', $post->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit">Delete post</button>
            </form></p>

            <p><form method="GET" action="{{ route('posts.edit', $post->id) }}">
                @csrf
                <button type="submit">Update post</button>
            </form></p>
        @endcan
    @endforeach


    <iframe width="560" height="315" src="https://www.youtube.com/embed/pMX2cQdPubk?si=Piw5T7cNnMsMiMjM" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
</body>
</html>
