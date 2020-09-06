@extends('layouts.app')

@section('style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/video.js/5.10.2/alt/video-js-cdn.css" rel="stylesheet">
<style>
    #video
    {
        width: 100%;
    }
</style>
@endsection

@section('content')
    @can('update', $video->channel)
        <div class="card-header text-right ">
            <a href="{{ route('videos.edit',$video->id) }}" class="btn btn-primary ">Update video</a>
        </div>
    @endcan

    <div class="card-body">


        <video id="video" class="video-js vjs-default-skin" preload="none" crossorigin="true" controls width="640" height="320" controls>
            <source
            src="/storage/videos/{{ $video->id }}/{{ $video->id }}.m3u8"
            type="application/x-mpegURL">
        </video>
        <div class="container mt-3 ">
            <div class="row">
                <div class="col-md-9 col-sm-12">
                    <h4 class="mb-0">{{ $video->title }}</h4>
                    <span style="color: gray;font-size:14px">
                        {{ $video->views }} {{ Str::plural('view', $video->views) }}
                    </span>
                </div>
                <div class="col-md-3 col-sm-12 text-right">
                    <app-vote
                        :default_votes="{{ $video->votes}}"
                        entity_id="{{ $video->id }}" ></app-vote>
                </div>
            </div>

            <p>
                {{ $video->description }}
            </p>
            <hr>
            <div class="row">
                <div class="col-md-7 col-12" style="position: relative;" >

                    <img src="{{ $video->channel->image }}" style="position:absolute;border-radius:50%" width="50px" class="border" alt="">
                    <div  style="position:absolute;left:80px" >
                        <h5 class="mb-0">{{ $video->channel->name }}</h5>
                        <span style="color: gray;font-size:14px" >
                            Published at {{ $video->created_at->format('d/m/Y') }}
                        </span>
                    </div>
                </div>
                <div class="col-md-5 col-12 text-right ">
                    <app-subscribe
                    subscribed="{{ $isSubscribed }}"
                    id="{{ $video->channel->id }}"
                    owner="{{ $video->channel->user->is(auth()->user()) }}"
                    subscribers="{{ $video->channel->users->count() }}" >
                    </app-subscribe>
                </div>
            </div>
            <hr>
            <h3>Comments</h3>
            <div class="row ml-1">
                <div class="col-12">
                    <app-comments video_id="{{ $video->id }}" ></app-comments>
                </div>

            </div>
        </div>
    </div>

@endsection







@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/video.js/5.10.2/video.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-hls/3.0.2/videojs-contrib-hls.js"></script>

<script>

    window.current_video = '{{ $video->id }}'

    localStorage.setItem('userId','{{ auth()->id() }}')
</script>

<script src="{{ asset('js/video.js') }}"></script>
@endsection

