@extends('layouts.app')
@section('title','Add New Post')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">Update Post</div>
                    <div class="card-body">
                        <form action="/posts/{{ $post->slug }}/edit" method="post" enctype="multipart/form-data">
                            @method('patch')
                            @csrf
                            @include('posts.partials.form-control')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection