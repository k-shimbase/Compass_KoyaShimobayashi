<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use Auth;

class PostsController extends Controller
{

    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    // ◆掲示板トップ画面(GET) | post.show
    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    public function show(Request $request){

        //◇全てのポストの取得/全てのメインカテゴリの取得
        $posts = Post::with('user', 'postComments')->get();
        $categories = MainCategory::get();

        //◇ビューファイルでそれぞれのモデルの関数を利用する為の空インスタンス作成
        $like = new Like;
        $post_comment = new Post;

        //◇キーワードによる検索
        if(!empty($request->keyword)){
            $posts = Post::with('user', 'postComments')
            ->where('post_title', 'like', '%'.$request->keyword.'%')
            ->orWhere('post', 'like', '%'.$request->keyword.'%')->get();

        //◇サブカテゴリー選択による検索とする
        }else if($request->category_word){
            $sub_category = $request->category_word;
            $posts = Post::with('user', 'postComments')->get();

        /*
        }else if($request->sub_category){
            $sub_category_id = $request->sub_category;

            $posts = Post::with('user', 'postComments')

                //◇post単体だとリレーションのみで可能だが、今回は特定のsub_categoryに属しているpost全てを取得する為
                //◇whereHasでテーブルに接続し(厳密にはwhereHasは中間テーブルとリレーション先モデルとの結合の為、post_sub_categories中間テーブルで完結するがコードの長さや見やすさの為whereHasを利用している)
                //◇そこからsub_categoryのidを利用してwhereでpost_idを絞り込んでいる
                ->whereHas('subCategories', function($query) use ($sub_category_id) {
                $query->where('sub_categories.id', $sub_category_id);
            })->get();
        */

        //◇いいねした投稿による検索
        }else if($request->like_posts){
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments')->whereIn('id', $likes)->get();

        //◇自分の投稿のみによる検索
        }else if($request->my_posts){
            $posts = Post::with('user', 'postComments')
            ->where('user_id', Auth::id())->get();
        }

        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'like', 'post_comment'));
    }

    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    // ◆投稿詳細画面(GET) | post.detail
    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    public function postDetail($post_id){
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    // ◆投稿作成画面(GET) | post.input
    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    public function postInput(){
        $main_categories = MainCategory::get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories'));
    }

    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    // ◇投稿作成処理(POST) | post.create
    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    public function postCreate(PostFormRequest $request){
        $post = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body
        ]);

        return redirect()->route('post.show');
    }

    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    // ◇投稿編集処理(POST) | post.edit
    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    public function postEdit(Request $request){
        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);

        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    // ◆投稿削除処理(GET) | post.delete
    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    public function postDelete($id){
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }

    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    // ◇メインカテゴリ作成処理(POST) | main.category.create
    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    public function mainCategoryCreate(Request $request){
        MainCategory::create(['main_category' => $request->main_category_name]);
        return redirect()->route('post.input');
    }

    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    // ◇サブカテゴリ作成処理(POST) | sub.category.create
    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    // ◇コメント作成処理(POST) | comment.create
    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    public function commentCreate(Request $request){
        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);

        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    // ◆自身のポスト表示画面(GET) | my.bulletin.board
    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    public function myBulletinBoard(){
        $posts = Auth::user()->posts()->get();
        $like = new Like;

        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    // ◆いいねしたポスト表示画面(GET) | like.bulletin.board
    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    public function likeBulletinBoard(){
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;

        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    // ◇投稿へのいいね処理(POST) | post.like
    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    public function postLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        return response()->json();
    }

    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    // ◇投稿へのいいね取り消し処理(POST) | post.unlike
    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    public function postUnLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
             ->where('like_post_id', $post_id)
             ->delete();

        return response()->json();
    }
}
