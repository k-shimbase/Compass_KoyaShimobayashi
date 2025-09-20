<x-sidebar>

<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<!-- ◆ ユーザプロフィール画面 (UsersController userProfile関数)             -->
<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<div class="vh-100 border">
  <div class="top_area w-75 m-auto pt-5">

    <!--◇ユーザ名表示-->
    <span>{{ $user->over_name }}</span><span>{{ $user->under_name }}さんのプロフィール</span>

    <!--◇ユーザ情報の表示-->
    <div class="user_status p-3">
      <p>名前 : <span>{{ $user->over_name }}</span><span class="ml-1">{{ $user->under_name }}</span></p>
      <p>カナ : <span>{{ $user->over_name_kana }}</span><span class="ml-1">{{ $user->under_name_kana }}</span></p>
      <p>性別 : @if($user->sex == 1)<span>男</span>@else<span>女</span>@endif</p>
      <p>生年月日 : <span>{{ $user->birth_day }}</span></p>

      <!--◇選択科目の表示-->
      <div>選択科目 :
        @foreach($user->subjects as $subject)
        <span>{{ $subject->subject }}</span>
        @endforeach
      </div>

      <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
      <!-- ◆ 選択科目の編集 (Admin権限に適合したユーザにのみ表示)                   -->
      <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
      <div class="">

        @can('admin')
        <span class="subject_edit_btn">選択科目の編集</span>
        <div class="subject_inner">
          <form action="{{ route('user.edit') }}" method="post">

            <!--◇subjects表示処理-->
            @foreach($subject_lists as $subject_list)
            <div>

              <!--◇科目名の表示/チェックボックスの配置とsubjects配列での送信指定-->
              <label>{{ $subject_list->subject }}</label>
              <input type="checkbox" name="subjects[]" value="{{ $subject_list->id }}">
            </div>
            @endforeach

            <!--◇編集ボタン/user_idのhidden送信指定-->
            <input type="submit" value="編集" class="btn btn-primary">
            <input type="hidden" name="user_id" value="{{ $user->id }}">

            <!--◇@csrf-->
            {{ csrf_field() }}

          </form>
        </div>
        @endcan

      </div>
    </div>
  </div>
</div>

</x-sidebar>
