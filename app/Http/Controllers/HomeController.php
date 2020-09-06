<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Video;
use App\Channel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $query = request('search');
        $videos = collect();
        $channels = collect();
        $results = '';

        if($query)
        {
            $videos = Video::where('title','Like',"%{$query}%")->orWhere('description','LIKE',"%{$query}%")->paginate(5,['*'],'videos');
            $channels = Channel::where('name','Like',"%{$query}%")->orWhere('description','LIKE',"%{$query}%")->paginate(5,['*'],'channles');
            if($videos->count() === 0 && $channels->count() === 0 )
            {
                $results = "No result";
            }
        }

        return view('home',[
            'videos' => $videos,
            'channels' => $channels,
            'results' => $results
        ]);
    }
}
