<x-sidebar>

<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<!-- ◆ ユーザ検索画面 (UsersController showUsers関数)                       -->
<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<p>ユーザー検索</p>
<div class="search_content w-100 border d-flex">

  <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
  <!-- ◆ 登録されているユーザの一覧表示エリア                                  -->
  <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
  <div class="reserve_users_area">
    @foreach($users as $user)
    <div class="border one_person">

      <!--◇ID表記-->
      <div>
        <span>ID : </span><span>{{ $user->id }}</span>
      </div>

      <!--◇名前表記-->
      <div><span>名前 : </span>
        <a href="{{ route('user.profile', ['id' => $user->id]) }}">
          <span>{{ $user->over_name }}</span>
          <span>{{ $user->under_name }}</span>
        </a>
      </div>

      <!--◇カナ表記-->
      <div>
        <span>カナ : </span>
        <span>({{ $user->over_name_kana }}</span>
        <span>{{ $user->under_name_kana }})</span>
      </div>

      <!--◇性別表記-->
      <div>
        @if($user->sex == 1)
        <span>性別 : </span><span>男</span>
        @elseif($user->sex == 2)
        <span>性別 : </span><span>女</span>
        @else
        <span>性別 : </span><span>その他</span>
        @endif
      </div>

      <!--◇生年月日表記-->
      <div>
        <span>生年月日 : </span><span>{{ $user->birth_day }}</span>
      </div>

      <!--◇権限(役職)表記-->
      <div>
        @if($user->role == 1)
        <span>権限 : </span><span>教師(国語)</span>
        @elseif($user->role == 2)
        <span>権限 : </span><span>教師(数学)</span>
        @elseif($user->role == 3)
        <span>権限 : </span><span>講師(英語)</span>
        @else
        <span>権限 : </span><span>生徒</span>
        @endif
      </div>

      <!--◇選択科目表記-->
      <div>
        @if($user->role == 4)

          <span>選択科目 :</span>

          @foreach($user->subjects as $subject)
          <span>{{ $subject->subject }}</span>
          @endforeach

        @endif
      </div>
    </div>
    @endforeach
  </div>

  <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
  <!-- ◆ 検索エリア                                                          -->
  <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
  <div class="search_area w-25 border">
    <div class="">

      <!--◇キーワード入力欄-->
      <div>
        <input type="text" class="free_word" name="keyword" placeholder="キーワードを検索" form="userSearchRequest">
      </div>

      <!--◇カテゴリ欄-->
      <div>
        <lavel>カテゴリ</lavel>
        <select form="userSearchRequest" name="category">
          <option value="name">名前</option>
          <option value="id">社員ID</option>
        </select>
      </div>

      <!--◇ソート欄-->
      <div>
        <label>並び替え</label>
        <select name="updown" form="userSearchRequest">
          <option value="ASC">昇順</option>
          <option value="DESC">降順</option>
        </select>
      </div>

      <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
      <!-- ◆ 検索条件追加エリア                                                   -->
      <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
      <div class="">
        <p class="m-0 search_conditions"><span>検索条件の追加</span></p>
        <div class="search_conditions_inner">

          <!--◇性別選択欄-->
          <div>
            <label>性別</label>
            <span>男</span><input type="radio" name="sex" value="1" form="userSearchRequest">
            <span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest">
            <span>その他</span><input type="radio" name="sex" value="3" form="userSearchRequest">
          </div>

          <!--◇権限(役職)選択欄-->
          <div>
            <label>権限</label>
            <select name="role" form="userSearchRequest" class="engineer">
              <option selected disabled>----</option>
              <option value="1">教師(国語)</option>
              <option value="2">教師(数学)</option>
              <option value="3">教師(英語)</option>
              <option value="4" class="">生徒</option>
            </select>
          </div>

          <!--◇選択科目欄-->
          <div class="selected_engineer">
            <label>選択科目</label>
              @foreach ($subjects as $subject)
              <br><span>{{ $subject->subject }}</span><input type="checkbox" name="subjects[]" value="{{ $subject->id }}" form="userSearchRequest">
              @endforeach
          </div>

        </div>
      </div>

      <!--◇リセットボタン-->
      <div>
        <input type="reset" value="リセット" form="userSearchRequest">
      </div>

      <!--◇検索ボタン-->
      <div>
        <input type="submit" name="search_btn" value="検索" form="userSearchRequest">
      </div>
    </div>

    <!--◇リクエスト送信フォーム-->
    <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>

  </div>
</div>
</x-sidebar>
