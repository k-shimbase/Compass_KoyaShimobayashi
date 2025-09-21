<?php
namespace App\Searchs;

use App\Models\Users\User;

class SelectIdDetails implements DisplayUsers{

  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  // ◆IDベース+科目(subjects)指定での検索方法
  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){

    //◇キーワードが指定されていない際
    if(is_null($keyword)){
      $keyword = User::get('id')->toArray(); //全ユーザのIDを配列で取得

    //◇キーワードが指定されている際
    }else{
      $keyword = array($keyword); //指定されたIDを配列で取得(要素数1)
    }





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




    //◇クエリ取得
    $users = User::with('subjects')

      //◇キーワードでidを絞り込む
      ->whereIn('id', $keyword)

      //◇whereのグループ化不要
      ->where(function($q) use ($role, $gender){
        $q->whereIn('sex', $gender)
        ->whereIn('role', $role);
      })

      //◇whereInにする必要がある(whereHasはクエリビルダ内で異なるテーブルへと接続できる唯一の方法である為利用されている/実際は中間テーブルとリレーション先のモデルのテーブルを結合させるものである/subject_usersのみで完結するが、こちらだと多少コードが長くなってしまう為見やすさという観点からwhereHasが利用されたと考えられる)
      ->whereHas('subjects', function($q) use ($subjects){
        $q->whereIn('subjects.id', $subjects);
      })

      ->orderBy('id', $updown)->get();





    //◇ユーザのインスタンス一覧を返す
    return $users;
  }

}
