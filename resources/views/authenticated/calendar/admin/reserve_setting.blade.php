<x-sidebar>

<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<!-- ◆ スクール枠登録画面/Admin (CalendarsController reserveSettings関数)   -->
<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<!--◆内容はCalendarsの各クラスを経由して定義されている-->

<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border shadow round m-auto pt-5 pb-5" style="width: 1150px; border-radius:5px; background:#FFF;">
    <div class="m-auto" style="border-radius:5px; width: 90%;">

      <!--◇内容描画-->
      <p class="text-center calendar_title">{{ $calendar->getTitle() }}</p>
      {!! $calendar->render() !!}

      <!--◇スクール枠上限登録ボタン-->
      <div class="text-right">
        <input type="submit" class="btn btn-primary" value="登録" form="reserveSetting" onclick="return confirm('登録してよろしいですか？')">
      </div>

    </div>
  </div>
</div>
</x-sidebar>
