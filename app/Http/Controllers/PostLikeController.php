<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Mail\PostLiked;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostLikeController extends Controller
{
    public function __construct()
    {
        # unauthenticated users can post and like
        $this->middleware(['auth']);
    }

    public function store(Post $post, Request $request)
    {
        // prevent users from liking post twice
        if ($post->likedBy($request->user())) {
            return response(null, 409);
        }

        $post->likes()->create([
            'user_id' => $request->user()->id,
        ]);

        // send email when user likes post
        $user = $post->user;

        if (!$post->likes()->onlyTrashed()->where('user_id', $request->user()->id)->count()) {
            Mail::to($user)->send(new PostLiked(auth()->user(), $post));
        }

        return back();
    }

    public function destroy(Post $post, Request $request)
    {
        $request->user()->likes()->where('post_id', $post->id)->delete();

        return back();
    }
}
