<?php

namespace App\Http\Controllers;

use App\Channel;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Http\Requests\UpdateChannelRequest;

class ChannelController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only('update');
    }






    /**
     * Display the specified resource.
     *
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function show(Channel $channel)
    {
        $isSubscribed = false;

        if(auth()->user())
        {
            $isSubscribed = auth()->user()->isSubscribed($channel);
        }

        return view('channels.show',[
            'channel' => $channel,
            'isSubscribed' => $isSubscribed,
            'subscribersNumber' => $channel->users->count(),
            'videos' => $channel->videos()->paginate(5)
        ]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateChannelRequest $request, Channel $channel)
    {

        $channel->update(request()->all());

        if(request('image'))
        {
            $this->storeImage($channel);
        }

        return redirect()->route('channels.show',$channel)->with('success','Your channel is updated successfully');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Channel $channel)
    {
        //
    }

    public function storeImage(Channel $channel)
    {
        $channel->update([
            'image' => request('image')->store("public/channels/$channel->id/images")
        ]);

        $image = Image::make(public_path($channel->image))->fit(200,200);
        $image->save();
    }
}
