@extends('layouts.app')


@section('content')
    <div class="card-header">
        <span>{{ $channel->name }}</span>
        @can('update', $channel)
            <a href="{{ Route('videos.upload',$channel->id) }}" class="float-right" >Upload videos</a>
        @endcan
    </div>

    <div class="card-body">

        @can('update',$channel)

       <form id="form-update-channel" action="{{ Route('channels.update',$channel->id) }}" method="POST" enctype="multipart/form-data" >

        @csrf
        @method('PUT')

        @endcan

        <div class="form-group row justify-content-center">
            <div class="channel-avatar border"  >
                <img src="{{ $channel->image }}" width="100%" alt="{{ $channel->name }}'s image">

                @can('update',$channel)
                    <div class="channel-avatar-overlay" onclick="document.getElementById('image-input').click()" >
                        <img src="/images/camera.png" >
                    </div>
                @endcan

            </div>

        </div>
        @can('update',$channel)

            <input type="file" onchange="document.getElementById('form-update-channel').submit()" id="image-input" name="image" style="display: none" >

            <div class="form-group">
                <label for="Name">Name</label>
                <input id="Name" class="form-control" type="text" required  value="{{ $channel->name }}" name="name">
                @error('name')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="Description">Description</label>
                <textarea name="description" id="Description" rows="3" class="form-control" >{{ $channel->description }}
                </textarea>
                @error('description')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            @error('image')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <button class="btn btn-primary" type="submit">Update channel</button>

            </form>
            @endcan

            <div class="text-center" >
                @cannot('update',$channel)
                    <p>{{ $channel->name }}</p>
                    <p>{{ $channel->description }}</p>
                @endcannot

                    <app-subscribe
                    subscribed="{{ $isSubscribed }}"
                    id="{{ $channel->id }}"
                    owner="{{ $channel->user->is(auth()->user()) }}"
                    subscribers="{{ $subscribersNumber }}" ></app-subscribe>
            </div>

            @if ($videos->count() !== 0)
            <table class="mt-1 table table-light table-bordered">
                <thead class="thead-light" >
                    <tr>
                        <th>image</th>
                        <th>Tilte</th>
                        <th>status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($videos as $video)
                    <tr>
                        <td>
                            <img width="40px" src="{{ $video->thumbnail }}" alt="" />
                        </td>
                        <td>
                            {{ $video->title }}
                        </td>
                        <td>
                            {{ $video->percentage === 100 ? 'Live' : 'Processing' }}
                        </td>
                        @if ($video->percentage === 100)
                        <td>
                            <a href="{{ route('videos.show',$video->id) }}" class="btn btn-primary" >View</a>
                        </td>
                        @endif
                    </tr>

                @endforeach
                </tbody>

        </table>
        <div class="row justify-content-center" >
            {{ $videos->links() }}
        </div>

            @endif


    </div>
    @endsection

