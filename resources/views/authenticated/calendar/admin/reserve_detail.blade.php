<x-sidebar>

<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<!-- ◆ スクール予約詳細画面/Admin (CalendarsController reserveDetail関数)   -->
<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-50 m-auto h-75">

    <!--◆日数とパートの表示-->
    <p><span>日</span><span class="ml-3">部</span></p>

    <!--◆該当日付/パートの予約者一覧エリア-->
    <div class="h-75 border">
      <table class="">

        <!--◇ユーザ表示処理-->
        <!--@foreach-->
        <tr class="text-center">
          <th class="w-25">ID</th>
          <th class="w-25">名前</th>
        </tr>
        <tr class="text-center">
          <td class="w-25"></td>
          <td class="w-25"></td>
        </tr>
        <!--@endforeach-->

      </table>
    </div>

  </div>
</div>
</x-sidebar>
