@extends('layouts.app')
@section('title','Post')
@section('content')
	<div class="container">
		
			<img style="height: 400px; object-fit: cover; object-position: center;" src="{{ $post->takeImage }}" alt="" class="rounded">
		
		<h3>{{ $post->title }}</h3>
		<div class="text-secondary">
			<a href="/categories/{{ $post->category->slug }}">{{ $post->category->name }}</a> 
			&middot; {{ $post->created_at->format('d F Y') }}
			&middot; 
			@foreach ($post->tags as $tag)
				<a href="/tags/{{ $tag->slug }}">{{ $tag->name }}</a>
			@endforeach

			<div class="media my-3">
				<img width="60" class="rounded-circle mr-3" src="{{ $post->author->gravatar() }}" alt="">
				<div class="media-body">
					<div>
						{{ $post->author->name }}
					</div>
					{{ '@'.$post->author->username }}
				</div>
			</div>
		</div>
		<hr>
		<p>{!! nl2br($post->body) !!}</p>
		
		<div>
			
			{{-- @if(auth()->user()->is($post->author)) --}}
			@can('delete', $post)
				<div class="flex mt-3">
					<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModalCenter">
						Delete
					</button>
                    <a href="/posts/{{ $post->slug }}/edit" class="btn btn-sm btn-success">Edit</a>
				</div>

			<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLongTitle">Are you sure ?</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div>{{ $post->title }}</div>
							<div class="mb-3 text-secondary">
									<small>Published: {{ $post->created_at->format('d F Y') }}</small>
							</div>
							<form action="/posts/{{ $post->slug }}/delete" method="POST">
								@csrf
								@method('delete')
								<div class="d-flex">
									<button class="btn btn-danger mr-2" type="submit">Yes</button>
									<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			@endcan
			{{-- @endif --}}
		</div>
	</div>
@endsection