<?php
namespace App\Calendars\General;

use App\Models\Calendars\ReserveSettings;
use Carbon\Carbon;
use Auth;

//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// ◆General階層
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

  function pastClassName(){
    return;
  }

  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  // ◆日付インスタンスの日にちを含んだpタグを返す format("j")が日付取得関数
  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  function render(){
    return '<p class="day">' . $this->carbon->format("j"). '日</p>';
  }

  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  // ◆通常表示のパート(処理対象日がログインユーザの予約日に含まれていなかった際の表示) セレクトボックス選択エリア
  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  function selectPart($ymd, $startDay, $toDay){

    $html = [];

    //◇過去日付の際の描画
    if($startDay <= $ymd && $toDay >= $ymd){

      $html[] = '<span class="calendar_past_text">受付終了</span>';
      $html[] = '<input type="hidden" name="getPart[]" form="reserveParts>';

    } else {

      //◇処理対象日のパート1, 2, 3のレコードを取得する(インスタンス取得)
      $one_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first();
      $two_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first();
      $three_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first();

      //◇パート1のレコードが存在した際
      if($one_part_frame){

        //◇パート1のlimit_usersの取得 (書き方が重複してしまっている)
        $one_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first()->limit_users;

      //◇パート1のレコードが存在しない際
      }else{
        $one_part_frame = '0';
      }

      //◇パート2のレコードが存在した際
      if($two_part_frame){
        $two_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first()->limit_users;
      }else{
        $two_part_frame = '0';
      }

      //◇パート3のレコードが存在した際
      if($three_part_frame){
        $three_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first()->limit_users;
      }else{
        $three_part_frame = '0';
      }





      //◇html記述(セレクトボックス)
      //◇getPart[]でセレクトボックス毎にデータを取得できる (getPart[1], getPart[2]など/各セレクトボックスのvalueが紐づけられている)
      $html[] = '<select name="getPart[]" class="border-primary" style="width:70px; border-radius:5px;" form="reserveParts">';
      $html[] = '<option value="" selected></option>';

      //パート1の残存数が0の際
      if($one_part_frame == "0"){
        $html[] = '<option value="1" disabled>リモ1部(残り0枠)</option>';
      }else{
        $html[] = '<option value="1">リモ1部(残り'.$one_part_frame.'枠)</option>';
      }

      //パート2の残存数が0の際
      if($two_part_frame == "0"){
        $html[] = '<option value="2" disabled>リモ2部(残り0枠)</option>';
      }else{
        $html[] = '<option value="2">リモ2部(残り'.$two_part_frame.'枠)</option>';
      }

      //パート3の残存数が0の際
      if($three_part_frame == "0"){
        $html[] = '<option value="3" disabled>リモ3部(残り0枠)</option>';
      }else{
        $html[] = '<option value="3">リモ3部(残り'.$three_part_frame.'枠)</option>';
      }

      //◇閉じタグ
      $html[] = '</select>';
    }

    return implode('', $html);
  }

  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  // ◆隠しデータとしてフォームに日付を送る為の要素
  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  function getDate(){
     return '<input type="hidden" value="'. $this->carbon->format('Y-m-d') .'" name="getData[]" form="reserveParts">';
  }

  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  // ◆Carbonインスタンスにformatを適用させる
  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  function everyDay(){
    return $this->carbon->format('Y-m-d');
  }

  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  // ◆ログインユーザの予約日を配列で取得
  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  function authReserveDay(){
    return Auth::user()->reserveSettings->pluck('setting_reserve')->toArray();
  }

  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  // ◆処理対象日がログインユーザの予約日に存在した際はレコードをクエリビルダとして返す
  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  function authReserveDate($reserveDate){
    return Auth::user()->reserveSettings->where('setting_reserve', $reserveDate);
  }

}
