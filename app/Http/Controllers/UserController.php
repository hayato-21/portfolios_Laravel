<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage; //ストレージにある写真を使用するため。
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\EditUser;
use Illuminate\Support\Facades\Auth;
use App\Friend;

class UserController extends Controller
{ // URL指定をするだけで、勝手に各々のアクションを行ってくれる。
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
    public function store(EditUser $request)
    {
        // ログインユーザーを取得する。
        $user =  Auth::user();

        //Nullの場合、処理を何もせずリダイレクトする（Nullなのに、ファイルに画像を入れる処理はおかしいため）
        if(empty($request->pic)){
            return redirect()->route('users.edit',[
                'user_id' => $user->id,
            ]);
        }
        $user->pic = base64_encode(file_get_contents($request->pic->getRealPath()));
        $user->save();

        return redirect()->route('users.edit', [
            'user_id' => $user->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //これは一旦保留。
    // public function show($id)
    // {
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();

        return view('users.profileEdit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditUser $request)
    {
        // ログインユーザー情報を取得
        $user = Auth::user();

        // ログインユーザー情報を更新する。
        $user->student_at_month = $request->student_at_month;
        $user->nickname = $request->nickname;
        $user->hoping_way = $request->hoping_way;
        $user->comments = $request->comments;
        $user->save();

        return redirect()->route('studylogs.index',[
            'id' => 1,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
