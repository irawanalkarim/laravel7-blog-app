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
                    <div class="card-header">New Post</div>
                    <div class="card-body">
                        <form action="/posts/store" method="post" enctype="multipart/form-data">
                            @csrf
                            @include('posts.partials.form-control', ['submit' => 'Create'])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection