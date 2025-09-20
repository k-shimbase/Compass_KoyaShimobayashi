<?php
namespace App\Searchs;

use App\Models\Users\User;

class AllUsers implements DisplayUsers{

  //◆AllUsersでしか利用していない為引数指定は不要なのでは
  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){
    $users = User::all();
    return $users;
  }


}
