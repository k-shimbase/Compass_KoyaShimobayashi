<?php

namespace App\Http\Controllers\Authenticated\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Gate;
use App\Models\Users\User;
use App\Models\Users\Subjects;
use App\Searchs\DisplayUsers;
use App\Searchs\SearchResultFactories;

class UsersController extends Controller
{

    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    // ◆ユーザ検索画面(GET) | user.show
    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    public function showUsers(Request $request){

        //◇リクエストの取得
        $keyword = $request->keyword;
        $category = $request->category;
        $updown = $request->updown;
        $gender = $request->sex;
        $role = $request->role;
        $subjects = null; //配列で検索時の選択科目一覧を受け取る

        //◇検索の役割を持つファクトリのインスタンスを作成/initializeUsersで検索実行(何故モデルを利用していないのか不明)
        //◇App/Searchs/SearchResultFactories.php
        $userFactory = new SearchResultFactories();
        $users = $userFactory->initializeUsers($keyword, $category, $updown, $gender, $role, $subjects);

        //◇全ての科目を取得(ビューファイルで利用する為)
        $subjects = Subjects::all();

        return view('authenticated.users.search', compact('users', 'subjects'));
    }

    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    // ◆ユーザプロフィール画面(GET) | user.profile
    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    public function userProfile($id){
        $user = User::with('subjects')->findOrFail($id);
        $subject_lists = Subjects::all();
        return view('authenticated.users.profile', compact('user', 'subject_lists'));
    }

    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    // ◇ユーザプロフィール編集処理(POST) | user.edit
    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    public function userEdit(Request $request){
        $user = User::findOrFail($request->user_id);
        $user->subjects()->sync($request->subjects);
        return redirect()->route('user.profile', ['id' => $request->user_id]);
    }
}
