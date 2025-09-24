<?php
namespace App\Searchs;

use App\Models\Users\User;

class SelectNames implements DisplayUsers{

  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  // ◆名前ベース指定での検索方法 (科目指定なし)
  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){

    //◇性別が選択されていない際
    if(empty($gender)){
      $gender = ['1', '2', '3']; //性別全指定

    //◇性別が選択されている際
    }else{
      $gender = array($gender); //指定された性別を配列で取得(要素数1)
    }





    //◇権限(役割)が選択されていない際
    if(empty($role)){
      $role = ['1', '2', '3', '4'];

      //◇権限(役割)が選択されている際
    }else{
      $role = array($role);
    }





    //◇クエリ実行
    $users = User::with('subjects')

      //◇whereでorWhere処理をグループ化
      ->where(function($q) use ($keyword){
        $q->where('over_name', 'like', '%'.$keyword.'%')
        ->orWhere('under_name', 'like', '%'.$keyword.'%')
        ->orWhere('over_name_kana', 'like', '%'.$keyword.'%')
        ->orWhere('under_name_kana', 'like', '%'.$keyword.'%');
      })

    ->whereIn('sex', $gender)
    ->whereIn('role', $role)

    ->orderBy('over_name_kana', $updown)->get();

    return $users;
  }
}
