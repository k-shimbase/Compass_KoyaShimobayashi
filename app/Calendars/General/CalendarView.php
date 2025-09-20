<?php
namespace App\Calendars\General;

use Carbon\Carbon;
use Auth;

//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// ◆General階層
//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
class CalendarView{

  private $carbon;
  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  // ◆ スクール予約画面の描画関数 | 実行元: CalendarController show | calendar.general.show
  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  function render(){
    $html = [];

    //◇カレンダーテーブルの開始タグ
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table">';

    //◇ヘッダー箇所(曜日表示/ thead=table header / tr=row / th=table header cell / td=table data(thのデータバージョン))
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th>月</th>';
    $html[] = '<th>火</th>';
    $html[] = '<th>水</th>';
    $html[] = '<th>木</th>';
    $html[] = '<th>金</th>';
    $html[] = '<th>土</th>';
    $html[] = '<th>日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';

    //◇各週の取得
    $weeks = $this->getWeeks();

    //◇それぞれの週毎に処理を実施
    foreach($weeks as $week){

      //◆週となる行の作成
      $html[] = '<tr class="'.$week->getClassName().'">';
      $days = $week->getDays();





      //◇週内の日付ごとに処理を行う
      foreach($days as $day){

        //◇過去日付か否かを確認する為の変数(月初と現在の日付)
        $startDay = $this->carbon->copy()->format("Y-m-01");
        $toDay = $this->carbon->copy()->format("Y-m-d");

        //◇処理対象日付がstartDay以上/現在日が処理対象日付以下(つまるところ処理対象の日付が月初以降かつ今日以前の際) everyDayはCalendarWeekDayクラスの関数(Carbonインスタンスにformatを適用する処理)
        if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
          $html[] = '<td class="calendar-td">'; //過去日付クラスの付与を行う
        }else{
          $html[] = '<td class="calendar-td '.$day->getClassName().'">'; //曜日クラス(このgetClassNameはCalendarWeekDayクラスの関数/曜日を返す/day-monのように)
        }

        //◇日付の表示を含むpタグが返ってくる(html[]配列に追加)
        $html[] = $day->render();





        //◇処理対象日がログインユーザの予約日に含まれていた際
        if(in_array($day->everyDay(), $day->authReserveDay())){

          //◇処理対象日がログインユーザの予約日に存在した際はレコードをクエリビルダとして返す(authReserveDate)
          //◇つまるところ、処理対象日がログインユーザの予約日に存在する際はその日の予約パートを取得する
          $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
          if($reservePart == 1){
            $reservePart = "リモ1部";
          }else if($reservePart == 2){
            $reservePart = "リモ2部";
          }else if($reservePart == 3){
            $reservePart = "リモ3部";
          }

          //◇過去日の際の描画 (getPart[]は空欄)
          //◇予約済みであった過去日の描画(<p>タグ)
          if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px"></p>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';

          //◇現在以降の日付の描画 (getPart[]は空欄)
          }else{

            /*
            //◇処理対象日がログインユーザの予約日に含まれていた際に該当予約日(パート)のレコードを取得する処理
            $reserve = $day->authReserveDate($day->everyDay()) //処理対象日が自身の予約日に含まれているか否かの確認
              ->where('setting_part', $reservePart) //パートで絞り込み
              ->first() //予約日の日付/パートと紐づいたreserve_settingsのレコードが返る(あとは$reserve->idを用いるだけ)
            //◇下記のdelete_dateで送る値も$reserve->idで良い
            */

            $html[] = '<button type="submit" class="btn btn-danger p-0 w-75" name="delete_date" style="font-size:12px" value="'. $day->authReserveDate($day->everyDay())->first()->setting_reserve .'">'. $reservePart .'</button>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }

        //◇処理対象日がログインユーザの予約日に含まれていなかった際 (getPart[]でパート指定あり)
        }else{
          $html[] = $day->selectPart($day->everyDay());
        }

        //getData[]として日付を指定する為の関数
        $html[] = $day->getDate();

        //◇reservePartsフォームで送られるキー
        //◇getPart[]は選択パート
        //◇getData[]は選択日付
        //◇配列の順番が一致している為、getData[1], getPart[1]の2種は対応している関係となる。

        //◇週内の日付の閉じタグ
        $html[] = '</td>';
      }





      //◇週となる行の閉じタグ
      $html[] = '</tr>';
    }

    //◇各種閉じタグ
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">'.csrf_field().'</form>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">'.csrf_field().'</form>';

    return implode('', $html);
  }

  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  // ◆ 各週の作成
  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  protected function getWeeks(){
    $weeks = [];

    //◇月初日と月末日
    $firstDay = $this->carbon->copy()->firstOfMonth();
    $lastDay = $this->carbon->copy()->lastOfMonth();

    //◇1週目を作成(第二引数省略の為デフォルト値で0となる)
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;

    //◇2週目以降を取得する(月初日+7日の週の週初日を取得/startOfWeek関数で実現)
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();

    //◇lteはCarbonクラスの関数であり、tmpDayがlastDay以下か否かを比較している
    while($tmpDay->lte($lastDay)){
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}
