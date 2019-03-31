<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PhotoRequest;
use App\Photo;
use App\Event;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{

    public function index()
    {
//        return response(Photo::all());
        $photos_data = Photo::all();
        foreach ($photos_data as $data){
            $contents = base64_encode(Storage::get("/sharing_photos/".$data->name));
            $data['photo'] = $contents;
        }
        return response($photos_data);
    }

    public function store(PhotoRequest $request)//第一引数は自作のリクエストチェック（バリデーション）
    {
        for ($j = 0; $j < $request->len ; $j++){//lenにはlengthが入っている
            $file_name = 'photo'.$j;//$request内の指定用の変数
            $photo_name = pathinfo($request->$file_name->getClientOriginalName(),PATHINFO_FILENAME);//ファイル名から拡張子を外している。
            $save_name = $photo_name.'_'.uniqid().'.'.$request->$file_name->getClientOriginalExtension();//ユニーク化のために関数使用。
            $request->$file_name->storeAs('/sharing_photos', $save_name);

            $photo = new Photo;
            $photo->name = $save_name;
            $photo->event_id = $request->event_id;//写真保存時にイベントデータと紐付け
            $photo->save();
        }
        //以下、イベントの写真保有数の登録。本来はEventPhotoRelationでやるべき。
        $event = Event::find($request->event_id);
        $event->photo_count = count($event->photos);
        $event->save();

//        $request->photo->storeAs('/sharing_photos', 'test.jpeg');//単数の基本形
    }

    public function destroy($id)
    {
        $photo = Photo::find($id);
        $event = Event::find($photo->event_id);

        Photo::destroy($id);
        //以下、イベントの写真保有数の調整。本来はEventPhotoRelationでやるべき。
        $event->photo_count = count($event->photos);
        $event->save();
    }
}
//https://php-junkie.net/framework/laravel/upload_image/
