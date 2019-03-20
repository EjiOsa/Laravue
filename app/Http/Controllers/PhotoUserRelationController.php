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

    }
}
