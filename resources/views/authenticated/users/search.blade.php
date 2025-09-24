<x-sidebar>

<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<!-- ◆ ユーザ検索画面 (UsersController showUsers関数)                       -->
<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<div class="search_content w-100 border d-flex">

  <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
  <!-- ◆ 登録されているユーザの一覧表示エリア                                  -->
  <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
  <div class="reserve_users_area">
    @foreach($users as $user)
    <div class="border one_person shadow round">

      <!--◇ID表記-->
      <div>
        <span class="text_grey">ID : </span><span class="text_black">{{ $user->id }}</span>
      </div>

      <!--◇名前表記-->
      <div><span class="text_grey">名前 : </span>
        <a class="text_cyan" href="{{ route('user.profile', ['id' => $user->id]) }}">
          <span>{{ $user->over_name }}</span>
          <span>{{ $user->under_name }}</span>
        </a>
      </div>

      <!--◇カナ表記-->
      <div>
        <span class="text_grey">カナ : </span>
        <span class="text_black">({{ $user->over_name_kana }}</span>
        <span class="text_black">{{ $user->under_name_kana }})</span>
      </div>

      <!--◇性別表記-->
      <div>
        @if($user->sex == 1)
        <span class="text_grey">性別 : </span><span class="text_black">男</span>
        @elseif($user->sex == 2)
        <span class="text_grey">性別 : </span><span class="text_black">女</span>
        @else
        <span class="text_grey">性別 : </span><span class="text_black">その他</span>
        @endif
      </div>

      <!--◇生年月日表記-->
      <div>
        <span class="text_grey">生年月日 : </span><span class="text_black">{{ $user->birth_day }}</span>
      </div>

      <!--◇権限(役職)表記-->
      <div>
        @if($user->role == 1)
        <span class="text_grey">権限 : </span><span class="text_black">教師(国語)</span>
        @elseif($user->role == 2)
        <span class="text_grey">権限 : </span><span class="text_black">教師(数学)</span>
        @elseif($user->role == 3)
        <span class="text_grey">権限 : </span><span class="text_black">講師(英語)</span>
        @else
        <span class="text_grey">権限 : </span><span class="text_black">生徒</span>
        @endif
      </div>

      <!--◇選択科目表記-->
      @if($user->role == 4)
      <div>
          <span class="text_grey">選択科目 :</span>

          @foreach($user->subjects as $subject)
          <span class="text_black">{{ $subject->subject }}</span>
          @endforeach

      </div>
      @endif
    </div>
    @endforeach
  </div>

  <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
  <!-- ◆ 検索エリア                                                          -->
  <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
  <div class="search_area">
    <div class="">

      <!--◇キーワード入力欄-->
      <div>
        <p class="search_h3 item_font">検索</p>
        <input type="text" class="free_word round btn box_background" name="keyword" placeholder="キーワードを検索" form="userSearchRequest">
      </div>

      <!--◇カテゴリ欄-->
      <div>
        <p class="item_font">カテゴリ</p>
        <select class="search_selectbox round btn box_background" form="userSearchRequest" name="category">
          <option value="name">名前</option>
          <option value="id">社員ID</option>
        </select>
      </div>

      <!--◇ソート欄-->
      <div>
        <p class="item_font">並び替え</p>
        <select class="search_selectbox round btn box_background" name="updown" form="userSearchRequest">
          <option value="ASC">昇順</option>
          <option value="DESC">降順</option>
        </select>
      </div>

      <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
      <!-- ◆ 検索条件追加エリア                                                   -->
      <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
      <div class="search_add">
        <div class="m-0 search_conditions item_font">
          <span>検索条件の追加</span><i class="bi bi-chevron-down fw-bold"></i>
        </div>

        <div class="search_conditions_inner">

          <!--◇性別選択欄-->
          <div class="mb-2">
            <p class="item_font">性別</p>
            <span>男</span><input type="radio" name="sex" value="1" form="userSearchRequest">
            <span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest">
            <span>その他</span><input type="radio" name="sex" value="3" form="userSearchRequest">
          </div>

          <!--◇権限(役職)選択欄-->
          <div class="mb-2">
            <p class="item_font">権限</p>
            <select class="search_selectbox role_selectbox round btn box_background" name="role" form="userSearchRequest" class="engineer">
              <option selected disabled>----</option>
              <option value="1">教師(国語)</option>
              <option value="2">教師(数学)</option>
              <option value="3">教師(英語)</option>
              <option value="4" class="">生徒</option>
            </select>
          </div>

          <!--◇選択科目欄-->
          <div class="selected_engineer">
            <p class="item_font">選択科目</p>
              @foreach ($subjects as $subject)
              <div class="search_subject">
                <span>{{ $subject->subject }}</span><input type="checkbox" name="subjects[]" value="{{ $subject->id }}" form="userSearchRequest">
              </div>
              @endforeach
          </div>

        </div>
      </div>

      <!--◇検索ボタン-->
      <div>
        <input type="submit" class="btn color_cyan search_btn round" name="search_btn" value="検索" form="userSearchRequest">
      </div>

      <!--◇リセットボタン-->
      <div class="d-flex">
        <input type="reset" class="search_reset" value="リセット" form="userSearchRequest">
      </div>

    </div>

    <!--◇リクエスト送信フォーム-->
    <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>

  </div>
</div>
</x-sidebar>
