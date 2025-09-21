<x-sidebar>

<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<!-- ◆ スクール予約詳細画面/Admin (CalendarsController reserveDetail関数)   -->
<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-50 m-auto h-75">

    <!--◆日数とパートの表示-->
    <p><span>{{ $formatted_date }}</span><span class="ml-3">{{ $part }}部</span></p>

    <!--◆該当日付/パートの予約者一覧エリア-->
    <div class="h-75 border">
      <table class="reserve_detail_table w-100">

        <!--◇ヘッダー-->
        <tr class="text-center table-row-flex">
          <th class="table-id">ID</th>
          <th class="table-name">名前</th>
          <th class="table-place">場所</th>
        </tr>

        <!--◇ユーザ表示処理-->
        @foreach ($reserveUsers as $user)
        <tr class="text-center table-row-flex">
          <td class="table-id">{{ $user->id }}</td>
          <td class="table-name">{{ $user->over_name }} {{ $user->under_name}}</td>
          <td class="table-place">リモート</td>
        </tr>
        @endforeach

      </table>
    </div>

  </div>
</div>
</x-sidebar>
