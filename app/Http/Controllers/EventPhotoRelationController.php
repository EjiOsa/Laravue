<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Illuminate\Support\Facades\Storage;

class EventPhotoRelationController extends Controller
{
    public function index($event_id)
    {
        //Eventから$event_idを元にphotosデータを取得する。
        $events_data = Event::find($event_id)->photos;
        foreach ($events_data as $event){
            $contents = base64_encode(Storage::get("/sharing_photos/".$event->name));
            $event['photo'] = $contents;
        }
        return response($events_data);
    }

    public function store(Request $request)
    {

    }
}
