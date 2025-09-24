<x-sidebar>

<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<!-- ◆ 掲示板トップ画面 (PostsController show関数)                          -->
<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<div class="board_area w-100 mt-4 d-flex">

  <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
  <!-- ◆ 投稿一覧表示エリア (画面左側エリア)                                   -->
  <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
  <div class="post_view mt-4" style="width: 70%;">
    <!--◆取得されている投稿表示処理-->
    @foreach($posts as $post)
    <div class="post_area border round m-auto p-3" style="width: 90%;">

      <!--◇ユーザ名-->
      <p class="post_username"><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>

      <!--◇投稿タイトル-->
      <p class="post_title"><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>





      <!--◇アイコンエリア-->
      <div class="post_bottom_area d-flex">

        <!--◇科目表示-->
        <div class="">
            @foreach ($post->subCategory as $sub_category)
              <span class="category_btn sub_category_frame color_cyan"> {{ $sub_category->sub_category }}</span>
            @endforeach
        </div>

        <div class="d-flex post_status">

          <!--◇コメントアイコン/コメント数の表示-->
          <div class="mr-5">
            <i class="fa fa-comment"></i><span class="">{{ $post_comment->commentCounts($post->id) }}</span>
          </div>

          <!--◇いいねアイコン/いいね数の表示-->
          <div style="margin-right: 15px;">
            @if(Auth::user()->is_Like($post->id))
            <p class="m-0"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span></p>
            @else
            <p class="m-0"><i class="far fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span></p>
            @endif
          </div>

        </div>
      </div>





    </div>
    @endforeach

  </div>





  <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
  <!-- ◆ 操作/検索エリア (画面右側エリア)                                      -->
  <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
  <div class="other_area" style="width: 25%;">
    <div class="other_area_contents m-4">

      <!--◇投稿ボタン-->
      <div class="btn post_button color_cyan"><a href="{{ route('post.input') }}">投稿</a></div>

      <!--◇キーワード入力テキストエリア-->
      <div class="keyword_flex">
        <input class="btn" type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest" style="width: 70%;">
        <input class="btn color_cyan" type="submit" value="検索" form="postSearchRequest" style="width: 30%;">
      </div>

      <!--◇いいねした投稿で検索/自分の投稿のみで検索/input type="submit"の特性でvalueがhtml上にも表示され、かつキーの値としても送信される-->
      <div class="like_or_own_flex">
        <input type="submit" name="like_posts" class="category_btn category_allow_click color_pink" value="いいねした投稿" form="postSearchRequest">
        <input type="submit" name="my_posts" class="category_btn category_allow_click color_yellow" value="自分の投稿" form="postSearchRequest">
      </div>

      <p class="mb-2">カテゴリー検索</p>

      <ul>
        <!--◇メインカテゴリ描画-->
        @foreach($main_categories as $main_category)
          <li class="main_categories">
            <div class="main_category_row">
              <span>{{ $main_category->main_category }}</span><i class="bi bi-chevron-down fw-bold"></i>
            </div>

            <div class="sub_categories">
              <ul>
                @foreach ($main_category->subCategory as $sub_category)
                <li><input type="submit" name="sub_category" class="sub_category_row" value="{{ $sub_category->sub_category }}" form="postSearchRequest"></inupt></li>
                @endforeach
              </ul>
            </div>
          </li>
        @endforeach
      </ul>

    </div>
  </div>

  <!--◆投稿用フォーム-->
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>

</div>
</x-sidebar>
