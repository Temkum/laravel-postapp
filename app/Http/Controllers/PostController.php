<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->with(['user', 'likes'])->paginate(12); //laravel collection

        return view('posts', ['posts' => $posts]);
    }

    public function store(Request $request)
    {
        # validate input
        $this->validate($request, [
            'body' => 'required'
        ]);

        /* currently authenticate user needs to have more than one more posts */
        $request->user()->posts()->create([
            'body' => $request->body,
        ]);

        return back();
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return back();
    }
}
