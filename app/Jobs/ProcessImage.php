<?php

namespace App\Jobs;

use App\Events\ImageUploadNotification;
use App\Models\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(){


        $url = $this->request['url'];
        $contents = file_get_contents($url); // downloading the image
        $name = time() . '__'. substr($url, strrpos($url, '/') + 1);// unique name
//        $contents->storeAs('uploads', $name, 'public');


        Storage::put('public/'.$name, $contents); // storing file inside public/storage/ folder

        $path = '/storage/'.$name;

        $newImage = new Image;
        $newImage->url = $path;
        $newImage->user_id = $this->request['user_id'];

        $newImage->save();

        broadcast(new ImageUploadNotification($this->request['user_id']));
    }
}
