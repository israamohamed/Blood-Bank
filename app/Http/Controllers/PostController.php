<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(5);
        return view('posts.index' , compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('posts.create' , compact('categories'));
    }

    public function store(Request $request)
    {
        $rules = [
            'category_id' => 'required' ,
            'title'       => 'required' ,
            'body'        => 'required' , 
            'image'       => 'image|nullable'
        ];

        $messages = [
            'image.image' => 'The file must be an image'
        ];

        $this->validate($request , $rules , $messages);

        if($request->hasFile('image'))
        {
            $path = $request->file('image')->store('public/posts_images');
        }

        $post = $request->user()->posts()->create($request->all());
        if($request->hasFile('image'))
        {
            $post->image = $request->image->hashName();
            $post->save();
        }
        

        return redirect(url(route('post.index')))->with('success','Post created successfully!');
    }


    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show' , compact('post'));
    }

    
    public function edit($id)
    {
        $post = Post::find($id);
        $categories = Category::all();
        return view('posts.edit' )->with([
            'post'       => $post ,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'category_id' => 'required' ,
            'title'       => 'required' ,
            'body'        => 'required' , 
            'image'       => 'image|nullable'
        ];

        $messages = [
            'image.image' => 'The file must be an image'
        ];

        $this->validate($request , $rules , $messages);

        $post = Post::findOrFail($id);
        $old_image = $post->image;
        $post->update($request->all());
        
        if($request->hasFile('image'))
        {
            Storage::delete('public/posts_images/'.$old_image);
            $path = $request->file('image')->store('public/posts_images');
            $post->image = $request->image->hashName();
            $post->save();
        }

        else 
        {
            if($request->input('remove'))
            {
                Storage::delete('public/posts_images/'.$old_image);
                $post->image = null;
                $post->save();
            }

        }
        
        return redirect(url(route('post.index')))->with('success','Post updated successfully!');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        Storage::delete('public/posts_images/'.$post->image);
        $post->delete();
        return redirect(url(route('post.index')))->with('warning','Post deleted successfully!');
    }
}
