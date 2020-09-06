<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use App\Video;
class CommentController extends Controller
{
    public function index(Video $video)
    {
        return $video->comments()->paginate(8);
    }

    public function show(Comment $comment)
    {
        return $comment->replies()->paginate(10);
    }

    public function store (Request $request,Video $video)
    {
        request()->validate([
            'body' => 'required|string'
        ]);

        return auth()->user()->comments()->create([
            'body' => request('body'),
            'video_id' => $video->id,
            'comment_id' => request('comment_id')
        ])->fresh();

    }
}
