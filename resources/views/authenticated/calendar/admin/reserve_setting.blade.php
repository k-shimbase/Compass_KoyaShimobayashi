<x-sidebar>

<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<!-- ◆ スクール枠登録画面/Admin (CalendarsController reserveSettings関数)   -->
<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<!--◆内容はCalendarsの各クラスを経由して定義されている-->

<div class="w-100 vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-100 vh-100 border p-5">

    <!--◇内容描画-->
    {!! $calendar->render() !!}

    <!--◇スクール枠上限登録ボタン-->
    <div class="adjust-table-btn m-auto text-right">
      <input type="submit" class="btn btn-primary" value="登録" form="reserveSetting" onclick="return confirm('登録してよろしいですか？')">
    </div>

  </div>
</div>
</x-sidebar>
