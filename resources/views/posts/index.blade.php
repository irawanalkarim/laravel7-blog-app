@extends('layouts.app')
@section('title','All Post')
@section('content')
    <div class="container">
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        
        @endif
        <div class="">
            <div>
                @isset($category)
                    <h4>Category:{{ $category->name }}</h4>
                @endisset

                @isset($tag)
                    <h4>Tag:{{ $tag->name }}</h4>
                @endisset

                @if (!isset($tag) && !isset($category))
                    <h4>All Post</h4>
                @endif
                <hr>
            </div>
            <div>
                @if (Auth::check())
                    <a href="/posts/create" class="btn btn-primary">Add New</a>
                @else 
                    <a href="/login" class="btn btn-primary">Login to create a post</a>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
            {{-- @if ($posts->count()) --}}
                @forelse ($posts as $item)
                    <div class="card mb-5 shadow">
                        @if ($item->thumbnail)
                            <a href="{{ route('posts.show' , $item->slug) }}">
                                <img style="height: 320px; object-fit: cover; object-position: center;" src="{{ $item->takeImage }}" alt="" class="card-img-top">
                            </a>
                        @endif
                        <div class="card-body">
                            <div>
                                <a href="{{ route('categories.show', $item->category->slug) }}" class="text-secondary">
                                    <small>
                                        {{ $item->category->name }} - 
                                    </small>
                                </a>
                                @foreach ($item->tags as $tag)
                                    <a href="{{ route('tags.show', $tag->slug) }}" class="text-secondary">
                                        <small>
                                            {{ $tag->name }}
                                        </small>
                                    </a>
                                @endforeach
                            </div>
                            <a href="{{ route('posts.show' , $item->slug) }}" class="card-title">
                                <h4>{{ $item->title }}</h4>
                            </a>
                            <div>
                                <p class="text-secondary">{{ Str::limit($item->body, 100) }}</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="media align-items-center">
                                    <img width="40" class="rounded-circle mr-3" src="{{ $item->author->gravatar() }}" alt="">
                                    <div class="media-body">
                                        <div>
                                            {{ $item->author->name }}
                                        </div>
                                    </div>
                                </div>
                                <div class="text-secondary">
                                    <small>
                                        Published on {{ $item->created_at->format('d F , Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                <div class="alert alert-info">
                    <Title>There are no posts.</Title>
                </div>
                @endforelse
            {{-- @endif --}}
        </div>
        {{ $posts->links() }}
    </div>
    </div>
@endsection