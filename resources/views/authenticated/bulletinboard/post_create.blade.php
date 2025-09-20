<x-sidebar>

<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<!-- ◆ 投稿作成画面 (PostsController postInput関数)                        -->
<!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
<div class="post_create_container d-flex">

  <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
  <!-- ◆ 投稿フォームエリア(左側のエリア)                                      -->
  <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
  <div class="post_create_area border w-50 m-5 p-5">
    <div class="">

      <!--◆カテゴリーを選択するセレクトボックス-->
      <p class="mb-0">カテゴリー</p>
      <select class="w-100" form="postCreate" name="post_category_id">

        @foreach($main_categories as $main_category)
        <optgroup label="{{ $main_category->main_category }}">
        <!--サブカテゴリー表示-->
        <!--optionタグによる追加(optgroupはグループ分けのタグであり、optgroup自身は選択不可)-->
        </optgroup>
        @endforeach

      </select>
    </div>



    <!--◆タイトル記入エリア-->
    <div class="mt-3">
      @if($errors->first('post_title'))
      <span class="error_message">{{ $errors->first('post_title') }}</span>
      @endif

      <p class="mb-0">タイトル</p>
      <input type="text" class="w-100" form="postCreate" name="post_title" value="{{ old('post_title') }}">
    </div>



    <!--◆投稿内容記入エリア-->
    <div class="mt-3">
      @if($errors->first('post_body'))
      <span class="error_message">{{ $errors->first('post_body') }}</span>
      @endif

      <p class="mb-0">投稿内容</p>
      <textarea class="w-100" form="postCreate" name="post_body">{{ old('post_body') }}</textarea>
    </div>



    <!--◆投稿ボタン-->
    <div class="mt-3 text-right">
      <input type="submit" class="btn btn-primary" value="投稿" form="postCreate">
    </div>

    <!--◆投稿用フォーム-->
    <form action="{{ route('post.create') }}" method="post" id="postCreate">{{ csrf_field() }}</form>
  </div>



  <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
  <!-- ◆ 管理者専用カテゴリー追加エリア(右側のエリア)                           -->
  <!--━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━-->
  @can('admin')
  <div class="w-25 ml-auto mr-auto">
    <div class="category_area mt-5 p-5">

      <!--◆メインカテゴリー追加欄-->
      <div class="">
        <p class="m-0">メインカテゴリー</p>
        <input type="text" class="w-100" name="main_category_name" form="mainCategoryRequest">
        <input type="submit" value="追加" class="w-100 btn btn-primary p-0" form="mainCategoryRequest">
      </div>

      <!--◆サブカテゴリー追加欄(メインカテゴリー選択セレクトボックス/サブカテゴリー追加テキストエリア)-->

      <!--◆各リクエストフォーム-->
      <form action="{{ route('main.category.create') }}" method="post" id="mainCategoryRequest">{{ csrf_field() }}</form>
    </div>

  </div>
  @endcan
</div>
</x-sidebar>
