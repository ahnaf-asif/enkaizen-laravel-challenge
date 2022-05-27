<?php

namespace App\Http\Controllers;

use App\Events\ImageUploadNotification;
use App\Jobs\ProcessImage; // image processing queued job
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    public function images(Request $req){
        return $req->user()->images;
    }
    public function upload(Request $req){
        ProcessImage::dispatch($req->all());
//        broadcast(new ImageUploadNotification());
        return response()->json(['msg' => 'your image is processing. you will be notified after it finishes']);
    }
}
