<x-sidebar>

<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<!-- ◆ 投稿詳細画面 (PostsController postDetail関数)                       -->
<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<div class="vh-100 d-flex">

  <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
  <!-- ◆ 投稿詳細エリア (画面左側エリア)                                       -->
  <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
  <div class="w-50 mt-5">
    <div class="m-3 w-90 detail_container">

      <div class="p-3">
        @if($errors->first('post_title'))
          <span class="error_message">{{ $errors->first('post_title') }}</span>
        @elseif ($errors->first('post_body'))
          <span class="error_message">{{ $errors->first('post_body') }}</span>
        @endif





        <div class="post_detail_area d-flex">

          <!--◇科目表示-->
          <div class="">
              @foreach ($post->subCategory as $sub_category)
                <span class="category_btn">{{ $sub_category->sub_category }}</span>
              @endforeach
          </div>

          <!--◆編集/削除ボタン-->
          <div class="detail_inner_head">
            <div>
              <!--sub_categoryの表示-->
            </div>

            @if (Auth::id() == $post->user->id)
            <div>
              <span class="edit-modal-open" post_title="{{ $post->post_title }}" post_body="{{ $post->post }}" post_id="{{ $post->id }}">編集</span>
              <a href="{{ route('post.delete', ['id' => $post->id]) }}" onclick="return confirm('削除してよろしいですか？')">削除</a>
            </div>
            @endif
          </div>
        </div>

        <!--◆投稿者の情報-->
        <div class="contributor d-flex">
          <p>
            <span>{{ $post->user->over_name }}</span>
            <span>{{ $post->user->under_name }}</span>
            さん
          </p>
          <span class="ml-5">{{ $post->created_at }}</span>
        </div>

        <!--◆投稿のタイトルと内容-->
        <div class="detsail_post_title">{{ $post->post_title }}</div>
        <div class="mt-3 detsail_post">{{ $post->post }}</div>
      </div>





      <!--◆投稿に紐づけられたコメント-->
      <div class="p-3">
        <div class="comment_container">
          <span class="">コメント</span>

          <!--◇各コメント表示処理-->
          @foreach($post->postComments as $comment)
          <div class="comment_area border-top">
            <p>
              <span>{{ $comment->commentUser($comment->user_id)->over_name }}</span>
              <span>{{ $comment->commentUser($comment->user_id)->under_name }}</span>さん
            </p>
            <p>{{ $comment->comment }}</p>
          </div>
          @endforeach

        </div>
      </div>
    </div>
  </div>





  <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
  <!-- ◆ コメント入力エリア (画面右側エリア)                                   -->
  <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
  <div class="w-50 p-3">
    <div class="comment_container border m-5">

      <div class="comment_area p-3">
        <p class="m-0">コメントする</p>

        <!--◇コメント入力テキストエリア-->
        <textarea class="w-100" name="comment" form="commentRequest"></textarea>

        <!--◇現在表示している投稿のpost_idをhiddenで送信する-->
        <input type="hidden" name="post_id" form="commentRequest" value="{{ $post->id }}">
        <input type="submit" class="btn btn-primary" form="commentRequest" value="投稿">

        <!--◇コメント送信用フォーム-->
        <form action="{{ route('comment.create') }}" method="post" id="commentRequest">{{ csrf_field() }}</form>
      </div>

    </div>
  </div>
</div>





<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<!-- ◆ 投稿編集モーダル                                                    -->
<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<div class="modal js-modal">

  <!--◆背景をクリックでモーダルを閉じる-->
  <div class="modal__bg js-modal-close"></div>

  <!--◆モーダルコンテンツ-->
  <div class="modal__content">
    <form action="{{ route('post.edit') }}" method="post">

      <div class="w-100">

        <!--◇タイトル-->
        <div class="modal-inner-title w-50 m-auto">
          <input type="text" name="post_title" placeholder="タイトル" class="w-100">
        </div>

        <!--◇投稿内容-->
        <div class="modal-inner-body w-50 m-auto pt-3 pb-3">
          <textarea placeholder="投稿内容" name="post_body" class="w-100"></textarea>
        </div>

        <!--◇閉じるボタンと投稿ボタン-->
        <div class="w-50 m-auto edit-modal-btn d-flex">
          <a class="js-modal-close btn btn-danger d-inline-block" href="">閉じる</a>
          <input type="hidden" class="edit-modal-hidden" name="post_id" value="">
          <input type="submit" class="btn btn-primary d-block" value="編集">
        </div>

      </div>

      <!--◇@csrf-->
      {{ csrf_field() }}
    </form>

  </div>
</div>
</x-sidebar>
