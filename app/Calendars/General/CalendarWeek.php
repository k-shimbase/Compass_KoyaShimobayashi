<?php
namespace App\Calendars\General;

use Carbon\Carbon;

//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// ◆General階層
//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
class CalendarWeek{
  protected $carbon;
  protected $index = 0;

  function __construct($date, $index = 0){
    $this->carbon = new Carbon($date);
    $this->index = $index;
  }

  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  // ◆ 各週の$indexを返す(コンストラクタで設定されたもの)
  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  function getClassName(){
    return "week-" . $this->index;
  }

  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  // ◆ 週内の日付を返す
  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   function getDays(){
     $days = [];

     //◇週初めと週終わりを取得
     $startDay = $this->carbon->copy()->startOfWeek();
     $lastDay = $this->carbon->copy()->endOfWeek();
     $tmpDay = $startDay->copy();

     //◇lastDayまで繰り返す
     while($tmpDay->lte($lastDay)){

      //◇tmpDayで加算された先の日付の月と現在の日付の月を比較し、異なる際は下記処理を実行する
       if($tmpDay->month != $this->carbon->month){

        //◇現在の日付インスタンスをCalendarWeekBlankDayインスタンスとして定義(親クラス/CalendarWeekDayのコンストラクタを引き継いでいる)
         $day = new CalendarWeekBlankDay($tmpDay->copy());
         $days[] = $day;
         $tmpDay->addDay(1);

         //◇繰り返し処理を1つ飛ばす
         continue;
        }

        //◇通常通りの処理/日付インスタンスをCalendarWeekDayとして定義
        $day = new CalendarWeekDay($tmpDay->copy());
        $days[] = $day;

        //◆1日加算
        $tmpDay->addDay(1);
      }
      return $days;
    }
  }
