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
        $subjects = $request->input('subjects');

        //◇検索の役割を持つクラスのインスタンスを作成/initializeUsersで検索実行(何故モデルを利用していないのか不明)
        //◇App/Searchs/SearchResultFactories.php
        $userFactory = new SearchResultFactories();
        $users = $userFactory->initializeUsers($keyword, $category, $updown, $gender, $role, $subjects);

        //◇全ての科目を取得(ビューファイルで利用する為)
        $subjects = Subjects::all();

        return view('authenticated.users.search', compact('users', 'subjects'));




        /*
        /  ◇下記記述のみで実現可能(クラスを使う必要がない)
        /
        //◇クエリビルダの準備
        $query = User::query();

        //◇カテゴリが名前の際(各カラムに対して部分一致の検索指定)
        if ($category == 'name') {
            $query->orderBy("over_name_kana", $updown);

            //◇キーワード指定
            $query->where(function ($whereQuery) use ($keyword) {
                $whereQuery->where('over_name', 'like', "%{$keyword}%")
                ->orWhere('under_name', 'like', "%{$keyword}%")
                ->orWhere('over_name_kana', 'like', "%{$keyword}%")
                ->orWhere('under_name_kana', 'like', "%{$keyword}%");
            });

        //◇カテゴリがIDの際(完全一致)
        } elseif ($category == 'id') {
            $query->orderBy("id", $updown);

            //◇キーワード指定(IDは完全一致である為入力されていた際のみ指定する)
            if (!empty($keyword)) {
                $query->where('id', $keyword);
            }
        }

        //◇性別指定
        if (!empty($gender)) {
            $query->where('sex', $gender);
        }

        //◇役職(権限)指定
        if (!empty($role)) {
            $query->where('role', $role);
        }

        //◇科目指定
        $subject_ids = $request->input('subjects');

        if (!empty($subject_ids)) {
            $query->whereHas('subjects', function ($where_query) use ($subject_ids) {
                $where_query->whereIn('subjects.id', $subject_ids);
            });
        }

        //◇クエリビルダの実行
        $users = $query->get();

        return view('authenticated.users.search', compact('users', 'subjects'));

         /
         /
        */
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
