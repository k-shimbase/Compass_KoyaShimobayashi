<?php
namespace App\Calendars\Admin;

use Carbon\Carbon;
use App\Models\Calendars\ReserveSettings;

//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// ◆Admin階層
//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
class CalendarWeekDay{
  protected $carbon;

  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  // ◆日付の曜日を小文字で返す(mon/tue/wed...sunなど) format("D")が曜日取得関数
  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  function getClassName(){
    return "day-" . strtolower($this->carbon->format("D"));
  }

  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  // ◆日付インスタンスの日にちを含んだpタグを返す format("j")が日付取得関数
  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  function render(){
    return '<p class="day">' . $this->carbon->format("j") . '日</p>';
  }

  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  // ◆Carbonインスタンスにformatを適用させる
  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  function everyDay(){
    return $this->carbon->format("Y-m-d");
  }

  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  // ◆予約確認画面の各パートの予約者数の表示
  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  function dayPartCounts($ymd){
    $html = [];

    //◇この段階で対象日付のレコードが取得できている(ReserveSettingsインスタンス)
    $one_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first();
    $two_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first();
    $three_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first();

    $html[] = '<div class="text-left">';

    //◇ReserveSettingsモデルからUserモデルへのリレーションの実施、そしてcount()関数で人数を取得
    //◇パート1のインスタンスの存在有無による処理
    if($one_part){
      $one_part_count = $one_part->users()->count();
      $one_part_link = '<a class="day_part m-0 pt-1" href="'.route('calendar.admin.detail', ['date' => $one_part->setting_reserve, 'part' => $one_part->setting_part]).'">1部</a>';
    } else {
      $one_part_count = 0;
      $one_part_link = '<span class="day_part m-0 pt-1">1部</span>';
    }

    //◇パート2のインスタンスの存在有無による処理
    if($two_part){
      $two_part_count = $two_part->users()->count();
      $two_part_link = '<a class="day_part m-0 pt-1" href="'.route('calendar.admin.detail', ['date' => $two_part->setting_reserve, 'part' => $two_part->setting_part]).'">2部</a>';
    } else {
      $two_part_count = 0;
      $two_part_link = '<span class="day_part m-0 pt-1">2部</span>';
    }

    //◇パート3のインスタンスの存在有無による処理
    if($three_part){
      $three_part_count = $three_part->users()->count();
      $three_part_link = '<a class="day_part m-0 pt-1" href="'.route('calendar.admin.detail', ['date' => $three_part->setting_reserve, 'part' => $three_part->setting_part]).'">3部</a>';
    } else {
      $three_part_count = 0;
      $three_part_link = '<span class="day_part m-0 pt-1">3部</span>';
    }

    //◇html配列へと格納
    $html[] = '<div class="part_flex">'.$one_part_link.'<p class="day_part_usercount m-0 pt-1">'.$one_part_count.'</p></div>';
    $html[] = '<div class="part_flex">'.$two_part_link.'<p class="day_part_usercount m-0 pt-1">'.$two_part_count.'</p></div>';
    $html[] = '<div class="part_flex">'.$three_part_link.'<p class="day_part_usercount m-0 pt-1">'.$three_part_count.'</p></div>';
    $html[] = '</div>';

    return implode("", $html);
  }


  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  // ◆パート1のlimit_usersの値を返す(1, 2, 3を全てひとつの関数にまとめられる)
  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  function onePartFrame($day){

    //◇day変数(y-m-d)を利用してreserve_settingsテーブルからsetting_reserveで絞り込む(この時点でpart 1, 2, 3が残存)
    //◇その後setting_part = 1でさらに絞り込み取得
    $one_part_frame = ReserveSettings::where('setting_reserve', $day)
      ->where('setting_part', '1')
      ->first();

    //◇該当日付の該当パートがreserve_settingsテーブルに登録されていた際
    if($one_part_frame){

      //◇書き方重複してしまっている($one_part_frame->limit-usersで問題ない)
      $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first()->limit_users;

    //◇登録されていなかった際
    }else{
      $one_part_frame = "20";
    }
    return $one_part_frame;
  }

  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  // ◆パート2のlimit_usersの値を返す
  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  function twoPartFrame($day){
    $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first();
    if($two_part_frame){
      $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first()->limit_users;
    }else{
      $two_part_frame = "20";
    }
    return $two_part_frame;
  }

  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  // ◆パート3のlimit_usersの値を返す
  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  function threePartFrame($day){
    $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first();
    if($three_part_frame){
      $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first()->limit_users;
    }else{
      $three_part_frame = "20";
    }
    return $three_part_frame;
  }

  //
  function dayNumberAdjustment(){
    $html = [];
    $html[] = '<div class="adjust-area">';
    $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;" name="1" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="2" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="3" type="text" form="reserveSetting"></p>';
    $html[] = '</div>';
    return implode('', $html);
  }
}
