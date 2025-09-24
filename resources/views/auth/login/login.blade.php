<x-guest-layout>

<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<!-- ◆ ログイン画面/guest (AuthenticatedSessionController create関数)      -->
<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
  <form action="{{ route('loginPost') }}" method="POST">

    <!--◆メインエリア(要素を画面中央に配置)-->
    <div class="w-100 vh-100 d-flex flex-column guest_container" style="align-items:center; justify-content:center;">

      <!--◇ロゴ-->
      <div class="atlas_logo"><img src="{{ asset('image/atlas-black.png') }}" alt="Atlas Logo"></div>

      <!--◇ログインボックス-->
      <div class="border vh-50 guest_form_area guest_login shadow">

        <!--◇メールアドレスエリア-->
        <div class="w-75 m-auto pt-5">
          <label class="d-block m-0" style="font-size:13px;">メールアドレス</label>
          <div class="border-bottom border-primary w-100">
            <input type="text" class="w-100 border-0" name="mail_address">
          </div>
        </div>

        <!--◇パスワードエリア-->
        <div class="w-75 m-auto pt-5">
          <label class="d-block m-0" style="font-size:13px;">パスワード</label>
          <div class="border-bottom border-primary w-100">
            <input type="password" class="w-100 border-0" name="password">
          </div>
        </div>

        <!--◇ログインボタン-->
        <div class="text-right m-3">
          <input type="submit" class="btn btn-primary" value="ログイン">
        </div>

        <!--◇新規登録画面への遷移リンク-->
        <div class="text-center">
          <a href="{{ route('registerView') }}">新規登録はこちら</a>
        </div>

      </div>

      <!--◇@csrf-->
      {{ csrf_field() }}
    </div>
  </form>
  </div>

  <!--◆JavaScript読み込み-->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="{{ asset('js/register.js') }}" rel="stylesheet"></script>

</x-guest-layout>
