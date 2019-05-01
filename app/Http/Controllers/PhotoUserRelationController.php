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

    public function store(Request $request)//ユーザーへの写真の紐付け(紐付けに関してはバック側で配列処理にしている。)
    {
        $user_id = $request->get('user_id');
        $move_photo_id_list = array_map('intval',explode(",", $request->get('move_id_str')));
        $user_photo_data = User::where('id', $user_id)->with('photos')->get()[0]->photos;
        $photo_id_list = [];//ここでリストを作成しておかないと、ユーザーの写真が全くない時にリストが作成されてなくて500エラーになる。
        foreach ($user_photo_data as $data){
            $photo_id_list[] = $data->id;//元々ユーザーに紐づいている写真IDをリストに格納
        }
        $photo_id_list = array_values(array_unique(array_merge($photo_id_list, $move_photo_id_list)));//追加分のリストとマージして、ユニークで重複削除。

        $user = User::find($user_id);
        $user->photos()->sync($photo_id_list);

//        $user->photo_count = count($photo_id_list);//これだと、重複した写真の場合にもカウントが増えて誤差がでる。
        $user->photo_count = count($user->photos);
        $user->save();
    }

    public function update(Request $request, $id)//ユーザーからの写真削除(削除に関しては配列で受け取らずに、フロント側でforで回している。)
    {
        $delete_photo_id[] = $request->id;
        $user = User::find($id);
        $user_photo_data = User::where('id', $id)->with('photos')->get()[0]->photos;
        foreach ($user_photo_data as $data){
            $photo_id_list[] = $data->id;
        }
        $photo_id_list = array_values(array_diff($photo_id_list, $delete_photo_id));//array_diffの第二引数は配列にしないといけない。
        $user->photos()->sync($photo_id_list);

//        $user->photo_count = count($photo_id_list);//上記同様。
        $user->photo_count = count($user->photos);
        $user->save();
    }
}
