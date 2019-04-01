<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Photo;
use App\User;

class RestAppEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Event::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = new Event;
        $event->name = $request->name;
        $event->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $event = Event::find($id);
        $event->name = $request->name;
        $event->save();
        return $event;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_photo_ids = Event::find($id)->photos->pluck('id');
        //find($id)でイベントを指定、そのイベントに紐づいているphotoを->photosで指定(コレクションで返ってくる)。
        //pluck('id')でphotoのidを取得。
        foreach ($delete_photo_ids as $delete_photo_id) {
            $delete_photo_users = Photo::find($delete_photo_id)->users;//削除したイベントに紐づいてるユーザーの指定
            Photo::destroy($delete_photo_id);
            //以下、ユーザーがいた場合の処理
            if (count($delete_photo_users)>0){
                foreach ($delete_photo_users as $delete_photo_user) {
                    //$user = User::where('id', $delete_photo_user->id);
                    $delete_photo_user->photo_count = count($delete_photo_user->photos);
                    $delete_photo_user->save();
                }
            }
        }
        Event::destroy($id);
    }
}
