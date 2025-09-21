<x-sidebar>

<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<!-- ◆ スクール予約画面/General (CalendarController show関数)               -->
<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<!--◆内容はCalendarsの各クラスを経由して定義されている-->

<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
    <div class="w-75 m-auto border" style="border-radius:5px;">

      <!--◇内容描画-->
      <p class="text-center">{{ $calendar->getTitle() }}</p>
      <div class="">
        {!! $calendar->render() !!}
      </div>

    </div>

    <!--◇スクール予約ボタン-->
    <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>

  </div>
</div>

<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<!-- ◆ 削除確認モーダル                                                    -->
<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<div class="modal js-modal">

  <!--◆背景をクリックでモーダルを閉じる-->
  <div class="modal__bg js-modal-close"></div>

  <!--◆モーダルコンテンツ-->
  <div class="modal__content">
    <form action="{{ route('deleteParts') }}" method="post">

      <div class="w-100">

        <!--◇予約日-->
        <div class="w-50 m-auto">
          <span class="delete_modal_text">予約日：</span><span class="modal_reserve_date"></span><br>
          <span class="delete_modal_text">時間：</span><span class="modal_reserve_part"></span>
          <p class="delete_modal_text">上記の予約をキャンセルしてもよろしいですか？</p>
        </div>

        <!--◇reserve_idの送信-->
        <input type="hidden" class="modal_reserve_id" name="reserve_id" value="">

        <!--◇閉じるボタンと投稿ボタン-->
        <div class="w-50 m-auto delete-modal-btn d-flex">
          <a class="js-modal-close btn btn-primary d-inline-block" href="">閉じる</a>
          <input type="submit" class="btn btn-danger d-block" value="キャンセル">
        </div>

      </div>

      <!--◇@csrf-->
      {{ csrf_field() }}
    </form>

  </div>
</div>
</x-sidebar>
