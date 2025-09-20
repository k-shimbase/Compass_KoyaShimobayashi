<?php
namespace App\Searchs;

use App\Models\Users\User;

class SelectIds implements DisplayUsers{

  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  // ◆IDベース指定での検索方法 (科目指定なし)
  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){

    //◇性別が選択されていない際
    if(is_null($gender)){
      $gender = ['1', '2', '3']; //性別全指定

    //◇性別が選択されている際
    }else{
      $gender = array($gender); //指定された性別を配列で取得(要素数1)
    }





    //◇権限(役割)が選択されていない際
    if(is_null($role)){
      $role = ['1', '2', '3', '4'];

    //◇権限(役割)が選択されている際
    }else{
      $role = array($role);
    }





    //◇クエリ取得(何故このような記述になっているのか…)
    //◇キーワードが未入力ではなかった際
    if(is_null($keyword)){
      $users = User::with('subjects')
      ->whereIn('sex', $gender)
      ->whereIn('role', $role)
      ->orderBy('id', $updown)->get();

    //◇キーワードが未入力であった際
    }else{
      $users = User::with('subjects')
      ->where('id', $keyword)
      ->whereIn('sex', $gender)
      ->whereIn('role', $role)
      ->orderBy('id', $updown)->get();
    }

    //◇ユーザのインスタンス一覧を返す
    return $users;
  }

}
