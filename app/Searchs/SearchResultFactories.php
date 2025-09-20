<?php
namespace App\Searchs;

use App\Models\Users\User;

class SearchResultFactories{

  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  // ◆検索内容に合致するuserインスタンスコレクションを返す(どの検索方法を利用するのか、とする分岐指定)
  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  public function initializeUsers($keyword, $category, $updown, $gender, $role, $subjects){

    //◆カテゴリが名前指定であった際
    if($category == 'name'){

      //◇名前ベースのみの検索方法(科目指定なし)
      if(is_null($subjects)){
        $searchResults = new SelectNames();

      //◇名前ベース+科目指定の検索方法
      }else{
        $searchResults = new SelectNameDetails();
      }

      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);





    //◆カテゴリがID指定であった際
    }else if($category == 'id'){

      //◇IDベースのみの検索方法(科目指定なし)
      if(is_null($subjects)){
        $searchResults = new SelectIds();

      //◇IDベース+科目指定の検索方法
      }else{
        $searchResults = new SelectIdDetails();
      }

      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);





    //◇デフォルト検索
    }else{
      $allUsers = new AllUsers();
      return $allUsers->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    }
  }
}
