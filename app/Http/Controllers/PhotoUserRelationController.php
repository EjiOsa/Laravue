<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Storage;

class PhotoUserRelationController extends Controller
{
    public function index($user_id)
    {
        //Userから$user_idを元にphotosを含めてデータを取得する。
        $users_data = User::where('id', $user_id)->with('photos')->get();
        //$users_dataが配列だったので、0番から。
        $photos_data = $users_data[0]->photos;
        foreach ($photos_data as $data){
            $contents = base64_encode(Storage::get("/sharing_photos/".$data->name));
            $data['photo'] = $contents;
        }
        return response($photos_data);
    }

    public function store(Request $request)
    {
        $user_id = $request->user_id;
        $photo_id = $request->photo_id;
        $user = User::find($user_id);
        $user_photo_data = User::where('id', $user_id)->with('photos')->get()[0]->photos;
        foreach ($user_photo_data as $data){
            $photo_id_list[] = $data->id;
        }
        $photo_id_list[] = $photo_id;
        $user->photos()->sync($photo_id_list);
    }
}
