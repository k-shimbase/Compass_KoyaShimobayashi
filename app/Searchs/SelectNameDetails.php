<?php
namespace App\Searchs;

use App\Models\Users\User;

class SelectNameDetails implements DisplayUsers{

  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  // ◆IDベース+科目(subjects)指定での検索方法
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





    //◇クエリ取得
    $users = User::with('subjects')

      //◇whereでorWhere処理をグループ化(orWhereは実際にクエリ文が作成された際にAND文の記述となる為、グループ化をしなかった際はWHERE ... LIKE ...OR...OR...AND...となってしまう。グループ化するとWHERE (OR...OR...) ANDとなる)
      ->where(function($q) use ($keyword){
        $q->Where('over_name', 'like', '%'.$keyword.'%')
        ->orWhere('under_name', 'like', '%'.$keyword.'%')
        ->orWhere('over_name_kana', 'like', '%'.$keyword.'%')
        ->orWhere('under_name_kana', 'like', '%'.$keyword.'%');
      })

      //◇whereのグループ化不要
      ->where(function($q) use ($role, $gender){
        $q->whereIn('sex', $gender)
        ->whereIn('role', $role);
      })

      //◇whereInにする必要がある(whereHasはクエリビルダ内で異なるテーブルへと接続できる唯一の方法である為利用されている/実際は中間テーブルとリレーション先のモデルのテーブルを結合させるものである/subject_usersのみで完結するが、こちらだと多少コードが長くなってしまう為見やすさという観点からwhereHasが利用されたと考えられる)
      ->whereHas('subjects', function($q) use ($subjects){
        $q->whereIn('subjects.id', $subjects);
      })

      ->orderBy('over_name_kana', $updown)->get();

    //◇ユーザのインスタンス一覧を返す
    return $users;
  }

}
