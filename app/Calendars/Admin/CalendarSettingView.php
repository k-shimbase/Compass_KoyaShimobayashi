<?php
namespace App\Calendars\Admin;
use Carbon\Carbon;
use App\Models\Calendars\ReserveSettings;

//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// ◆Admin階層
//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
class CalendarSettingView{
  private $carbon;

  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  // ◆ スクール枠登録画面の描画関数 | 実行元: CalendarsController reserveSettings | calendar.admin.setting
  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  public function render(){
    $html = [];

    //◇カレンダーテーブルの開始タグ
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table m-auto border adjust-table">';

    //◇ヘッダー箇所(曜日表示/ thead=table header / tr=row / th=table header cell / td=table data(thのデータバージョン))
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th class="border">月</th>';
    $html[] = '<th class="border">火</th>';
    $html[] = '<th class="border">水</th>';
    $html[] = '<th class="border">木</th>';
    $html[] = '<th class="border">金</th>';
    $html[] = '<th class="border">土</th>';
    $html[] = '<th class="border">日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';

    //◇各週の取得
    $weeks = $this->getWeeks();

    //◇それぞれの週毎に処理を実施
    foreach($weeks as $week){

      //◆週となる行の作成
      $html[] = '<tr class="'.$week->getClassName().'">'; //CalendarWeekクラスの関数($indexを返す)
      $days = $week->getDays(); //CalendarWeekクラスの関数(週内の日付リストを取得)





      //◇週内の日付ごとに処理を行う
      foreach($days as $day){

        //◇過去日付か否かを確認する為の変数(月初と現在の日付)
        $startDay = $this->carbon->format("Y-m-01");
        $toDay = $this->carbon->format("Y-m-d");

        //◇処理対象日付がstartDay以上/現在日が処理対象日付以下(つまるところ処理対象の日付が月初以降かつ今日以前の際) everyDayはCalendarWeekDayクラスの関数(Carbonインスタンスにformatを適用する処理)
        if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
          $html[] = '<td class="past-day border">'; //過去日付クラス
        }else{
          $html[] = '<td class="border '.$day->getClassName().'">'; //曜日クラス(このgetClassNameはCalendarWeekDayクラスの関数/曜日を返す/day-monのように)
        }

        //◇日付の表示を含むpタグが返ってくる(html[]配列に追加)
        $html[] = $day->render();





        //◇柔軟な調整が可能なエリア(こちらの意思で組み換え可能な汎用的エリア)
        $html[] = '<div class="adjust-area">';

        //◇CalendarWeekBlankDayインスタンスか否かの判定(CalendarWeekBlankDayクラスのeveryDay関数は空文字である''を返す為、その判定)
        if($day->everyDay()){

          //◇過去日の際の描画
          if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
            $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;" name="reserve_day['.$day->everyDay().'][1]" type="text" form="reserveSetting" value="'.$day->onePartFrame($day->everyDay()).'" disabled></p>';
            $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="reserve_day['.$day->everyDay().'][2]" type="text" form="reserveSetting" value="'.$day->twoPartFrame($day->everyDay()).'" disabled></p>';
            $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="reserve_day['.$day->everyDay().'][3]" type="text" form="reserveSetting" value="'.$day->threePartFrame($day->everyDay()).'" disabled></p>';

          //◇現在以降の日付の描画
          }else{
            $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;" name="reserve_day['.$day->everyDay().'][1]" type="text" form="reserveSetting" value="'.$day->onePartFrame($day->everyDay()).'"></p>';
            $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="reserve_day['.$day->everyDay().'][2]" type="text" form="reserveSetting" value="'.$day->twoPartFrame($day->everyDay()).'"></p>';
            $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="reserve_day['.$day->everyDay().'][3]" type="text" form="reserveSetting" value="'.$day->threePartFrame($day->everyDay()).'"></p>';
          }
        }

        //◇柔軟な調整が可能なエリアの閉じタグ
        $html[] = '</div>';

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
    $html[] = '<form action="'.route('calendar.admin.update').'" method="post" id="reserveSetting">'.csrf_field().'</form>';
    return implode("", $html);
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
