<x-sidebar>

<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<!-- ◆ スクール予約詳細画面/Admin (CalendarsController reserveDetail関数)   -->
<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<div class="vh-100 pt-5" style="background:#ECF1F6;">

  <div class="m-auto" style="width: 900px;">

    <!--◆日数とパートの表示-->
    <div class="detail_title">
      <span>{{ $formatted_date }}</span><span class="ml-3">{{ $part }}部</span>
    </div>

    <!--◆テーブルエリア-->
    <div class="border shadow round m-auto" style="border-radius:5px; background:#FFF;">
      <div class="reserve_detail_area" style="border-radius:5px;">

        <!--◆該当日付/パートの予約者一覧エリア-->
        <div class="h-75 border">
          <table class="reserve_detail_table w-100">

            <!--◇ヘッダー-->
            <tr class="text-center table_row_flex color_cyan">
              <th class="table_id">ID</th>
              <th class="table_name">名前</th>
              <th class="table_place">場所</th>
            </tr>

            <!--◇ユーザ表示処理-->
            @foreach ($reserveUsers as $user)
            <tr class="text-center table_row_flex table_date">
              <td class="table_id">{{ $user->id }}</td>
              <td class="table_name">{{ $user->over_name }} {{ $user->under_name}}</td>
              <td class="table_place">リモート</td>
            </tr>
            @endforeach

          </table>
        </div>

      </div>
    </div>
  </div>
</div>
</x-sidebar>
