<x-sidebar>

<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<!-- ◆ 掲示板トップ画面 (PostsController show関数)                          -->
<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<div class="board_area w-100 border m-auto d-flex">

  <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
  <!-- ◆ 投稿一覧表示エリア (画面左側エリア)                                   -->
  <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
  <div class="post_view w-75 mt-5">
    <p class="w-75 m-auto">投稿一覧</p>

    <!--◆取得されている投稿表示処理-->
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">

      <!--◇ユーザ名-->
      <p><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>

      <!--◇投稿タイトル-->
      <p><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>





      <!--◇アイコンエリア-->
      <div class="post_bottom_area d-flex">
        <div class="d-flex post_status">

          <!--◇コメントアイコン/コメント数の表示-->
          <div class="mr-5">
            <i class="fa fa-comment"></i><span class=""></span>
          </div>

          <!--◇いいねアイコン/いいね数の表示-->
          <div>
            @if(Auth::user()->is_Like($post->id))
            <p class="m-0"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}"></span></p>
            @else
            <p class="m-0"><i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}"></span></p>
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
  <div class="other_area border w-25">
    <div class="border m-4">

      <!--◇投稿ボタン-->
      <div class=""><a href="{{ route('post.input') }}">投稿</a></div>

      <!--◇キーワード入力テキストエリア-->
      <div class="">
        <input type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input type="submit" value="検索" form="postSearchRequest">
      </div>

      <!--◇いいねした投稿で検索/自分の投稿のみで検索/input type="submit"の特性でvalueがhtml上にも表示され、かつキーの値としても送信される-->
      <input type="submit" name="like_posts" class="category_btn" value="いいねした投稿" form="postSearchRequest">
      <input type="submit" name="my_posts" class="category_btn" value="自分の投稿" form="postSearchRequest">

      <ul>
        <!--◇メインカテゴリ描画-->
        @foreach($categories as $category)

          <li class="main_categories" category_id="{{ $category->id }}">
            <span>{{ $category->main_category }}</span>

            <!--◇@foreach ($category->subCategory as sub_category)-->
            <!--<input type="submit" name="sub_category" class="category_btn" value="{{ $sub_category->id }}" form="postSearchRequest">-->
          </li>

        @endforeach
      </ul>

    </div>
  </div>

  <!--◆投稿用フォーム-->
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>

</div>
</x-sidebar>
