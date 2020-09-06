<?php

namespace App\Http\Controllers;

use App\Video;
use App\Comment;
use Illuminate\Http\Request;

class VoteController extends Controller
{

    public function store(Request $request,$entityId)
    {
        $entity = $this->getEntity($entityId);

        $vote = $entity->votes->where('user_id',auth()->id())->first();

        if($vote)
        {
            return $vote->update([
                'type' => request('type')
            ]);
        }

        return $entity->votes()->create([
            'type' => request('type'),
            'user_id' => auth()->id()
        ]);

    }



    public function destroy($entityId)
    {
        $entity = $this->getEntity($entityId);
        $vote = $entity->votes->where('user_id',auth()->id())->first();

        return $vote->delete();
    }


    public function getEntity($id)
    {
        $video = Video::find($id);

        if($video)
        {
            return $video;
        }
        else
        {
            $comment = Comment::find($id);

            if($comment)
            {
                return $comment;
            }
        }


    }
}
