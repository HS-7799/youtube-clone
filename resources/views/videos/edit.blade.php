@extends('layouts.app')

@section('content')

    <div class="card-header">
        Update video
        <div class="float-right"  >
            <a href="{{ Route('videos.show',$video->id) }}" class="btn btn-dark">Back</a>
        </div>

    </div>

    <div class="card-body" >
        <form action="{{ Route('videos.update',$video->id) }}" method="POST" >
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Title</label>
                <input id="title" class="form-control" value="{{ $video->title }}"  type="text" name="title">
                @error('title')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description"  rows="3" class="form-control">{{ $video->description }}
                </textarea>
                @error('description')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary" >Update</button>
        </form>
    </div>

@endsection
