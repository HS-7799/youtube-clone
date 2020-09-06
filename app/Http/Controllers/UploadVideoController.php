<?php

namespace App\Http\Controllers;

use App\Channel;
use Illuminate\Http\Request;
use App\Jobs\ConvertForStreaming;
use App\Http\Requests\UploadVideoRequest;
use App\Jobs\CreateVideoThumbnail;

class UploadVideoController extends Controller
{
    public function index(Channel $channel)
    {
        $this->authorize('update',$channel);



        return view('channels.upload',[
            'channel' => $channel
        ]);
    }

    public function store(UploadVideoRequest $request,Channel $channel)
    {

        $video = $channel->videos()->create([
            'title' => request('title'),
            'path' => request('video')->store("/channels/$channel->id/videos"),
        ]);

        $this->dispatch(new CreateVideoThumbnail($video));
        $this->dispatch(new ConvertForStreaming($video));

        return $video;
    }
}
