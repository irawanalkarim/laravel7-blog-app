<?php

namespace App\Http\Controllers;

use App\{Category, Post, Tag};
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::with('author','tags','category')->latest()->paginate(5)
        ]);
    }

    public function show(Post $post) {
        $posts = Post::where('category_id',$post->category_id)->latest()->limit(5);
        return view('posts.show', compact('post'));
    }

    public function create() {
        return view('posts.create', [
            'post' => new Post(),
            'categories' => Category::get(),
            'tags' => Tag::get()
        ]);
    }

    public function store(PostRequest $request) {
        
        $request->validate([
            'thumbnail' => 'image|mimes:jpeg,jpg,png,svg|max:20480'
        ]);

        $attr = $request->all();
        $slug = \Str::slug(request('title'));
        $attr['slug'] = $slug;
        if(request()->file('thumbnail')) {
            $thumbnail = request()->file('thumbnail')->store("images/posts");
        } else {
            $thumbnail = null;
        }

        $attr['category_id'] = request('category');
        $attr['thumbnail'] = $thumbnail;
        
        $post = auth()->user()->posts()->create($attr);

        $post->tags()->attach(request('tags'));

        session()->flash('success', 'The post was created');

        return redirect('posts');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', [
            'post' => $post,
            'categories' => Category::get(),
            'tags' => Tag::get()
        ]);
    }

    public function update(PostRequest $request , Post $post)
    {
        $request->validate([
            'thumbnail' => 'image|mimes:jpeg,jpg,png,svg|max:2048'
        ]);

        $this->authorize('update', $post);
        if(request()->file('thumbnail')) {
            \Storage::delete($post->thumbnail);
            $thumbnail = request()->file('thumbnail')->store("images/posts");
        } else {
            $thumbnail = $post->thumbnail;
        }
        
        $attr = $request->all();
        $attr['category_id'] = request('category');
        $attr['thumbnail'] = $thumbnail;
        
        $post->update($attr);
        $post->tags()->sync(request('tags'));

        session()->flash('success','Post was successfully updated');
        
        return redirect('posts');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete',$post);
        \Storage::delete($post->thumbnail);
        $post->tags()->detach();
        $post->delete();
        session()->flash('success','Deleted');
        return redirect('posts');
    }
}
