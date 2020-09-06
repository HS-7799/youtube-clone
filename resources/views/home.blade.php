@extends('layouts.app')

@section('content')
        <div class="card-header">{{ __('Dashboard') }}</div>

        <div class="card-body">
            <form action="">
                <input type="search" name="search" class="form-control" placeholder="Search videos and Channels" >
            </form>

            @if ($results !== '')
                <h1>{{ $results }}</h1>
            @endif

            @if ($channels->count() !== 0)
            <h3>Channels</h3>
            <table class="table table-light">
                <thead class="thead-light">
                    <tr>
                        <th>Name</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($channels as $channel)
                    <tr>
                        <td>
                            {{ $channel->name }}
                        </td>
                        <td>
                            <a href="{{ Route('channels.show',$channel->id) }}" class="btn btn-primary">
                                View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row justify-content-center" >
                {{ $channels->appends(request()->query())->links() }}
            </div>
            @endif
            @if ($videos->count() !== 0)
            <h3>Videos</h3>
            <table class="table table-light">
                <thead class="thead-light">
                    <tr>
                        <th>Title</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($videos as $video)
                    <tr>
                        <td>
                            {{ $video->title }}
                        </td>
                        <td>
                            <a href="{{ Route('videos.show',$video->id) }}" class="btn btn-primary">
                                View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row justify-content-center" >
                {{ $videos->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
@endsection
