<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class RestAppUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(User::all());
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
        $user = new User;
        $user->family_name = $request->family_name;
        $user->first_name = $request->first_name;
        $user->age = $request->age;
        $user->email = $request->email;
        $user->password = Hash::make($request->first_name . $request->age);
        $user->api_token = str_random(60);
        //管理画面で確認するため、ハッシュ化しない。//でもログインではハッシュ化が必要なのでハッシュ化する。管理画面には表示せず。first_nameと年齢でパスワード
        $user->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        $photo_count = User::find($id)->employees;

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
        $user = User::find($id);
        $user->family_name = $request->family_name;
        $user->first_name = $request->first_name;
        $user->age = $request->age;
        $user->email = $request->email;
//        $user->password = Hash::make($request->password);//ハッシュ化した文字列を再ハッシュ化するので、ハッシュ化しない。//パスワードは自動生成にして、表示しないのでコメントアウト。
//        $user->password = $request->password;
        $user->save();
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
    }
}
