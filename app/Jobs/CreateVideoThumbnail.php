<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class CreateVideoThumbnail implements ShouldQueue
{
    public $video;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $path = 'thumbnails/'.$this->video->id.'.png';

        FFMpeg::fromDisk('local')
        ->open($this->video->path)
        ->getFrameFromSeconds(1)
        ->export()
        ->toDisk('local')
        ->save('public/thumbnails/'.$this->video->id.'.png');



        $this->video->thumbnail = $path;
        $this->video->save();
    }
}
