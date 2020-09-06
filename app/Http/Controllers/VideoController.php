<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Http\Request;

use App\http\Requests\UpdateVideoRequest;


class VideoController extends Controller
{
    public function show(Video $video)
    {
        if(request()->wantsJson())
        {
            return $video;
        }

        return view('videos.show',[
            'video' => $video,
            'isSubscribed' => auth()->user() ? auth()->user()->isSubscribed($video->channel) : false
        ]);
    }

    public function edit(Video $video)
    {

        $this->authorize('update',$video->channel);

        return view('videos.edit',compact('video'));

    }

    public function update(UpdateVideoRequest $request,Video $video)
    {
        $video->update($request->only(['title','description']));
        return redirect()->route('videos.show',$video->id)->with('success','Video updated successfully');

    }



    public function updateViews(Video $video)
    {
        $video->increment('views');

    }
}
