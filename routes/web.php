<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Authenticated\BulletinBoard\PostsController;
use App\Http\Controllers\Authenticated\Calendar\Admin\CalendarsController;
use App\Http\Controllers\Authenticated\Calendar\General\CalendarController;
use App\Http\Controllers\Authenticated\Top\TopsController;
use App\Http\Controllers\Authenticated\Users\UsersController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__.'/auth.php';

Route::group(['middleware' => 'auth'], function(){

    Route::namespace('Authenticated')->group(function(){

        //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        // ▮ トップ画面
        //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        Route::namespace('Top')->group(function(){

            //◇ログアウト
            Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

            //◇トップ画面
            Route::get('top', [TopsController::class, 'show'])->name('top.show');
        });

        //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        // ▮ スクール予約関連
        //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        Route::namespace('Calendar')->group(function(){

            //◆アドミン限定表示
            Route::namespace('Admin')->group(function(){

                //◇スクール予約確認画面
                Route::get('calendar/{user_id}/admin', [CalendarsController::class, 'show'])->name('calendar.admin.show');

                //◇スクール予約詳細画面
                Route::get('calendar/{date}/{part}', [CalendarsController::class, 'reserveDetail'])->name('calendar.admin.detail');

                //◇スクール枠登録/登録更新処理
                Route::get('setting/{user_id}/admin', [CalendarsController::class, 'reserveSettings'])->name('calendar.admin.setting');
                Route::post('setting/update/admin', [CalendarsController::class, 'updateSettings'])->name('calendar.admin.update');
            });

            //◆デフォルト表示
            Route::namespace('General')->group(function(){

                //◇スクール予約/予約処理/予約削除処理
                Route::get('calendar/{user_id}', [CalendarController::class, 'show'])->name('calendar.general.show');
                Route::post('reserve/calendar', [CalendarController::class, 'reserve'])->name('reserveParts');
                Route::post('delete/calendar', [CalendarController::class, 'delete'])->name('deleteParts');
            });
        });

        //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        // ▮ 掲示板関連
        //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        Route::namespace('BulletinBoard')->group(function(){

            //◇掲示板トップ画面
            Route::get('bulletin_board/posts/{keyword?}', [PostsController::class, 'show'])->name('post.show');

            //◇投稿作成画面/自身の投稿表示画面/いいねした投稿表示画面
            Route::get('bulletin_board/input', [PostsController::class, 'postInput'])->name('post.input');
            Route::get('bulletin_board/my_post', [PostsController::class, 'myBulletinBoard'])->name('my.bulletin.board');
            Route::get('bulletin_board/like', [PostsController::class, 'likeBulletinBoard'])->name('like.bulletin.board');

            //◇投稿作成処理
            Route::post('bulletin_board/create', [PostsController::class, 'postCreate'])->name('post.create');

            //◇メインカテゴリ作成/サブカテゴリ作成
            Route::post('create/main_category', [PostsController::class, 'mainCategoryCreate'])->name('main.category.create');
            Route::post('create/sub_category', [PostsController::class, 'subCategoryCreate'])->name('sub.category.create');

            //◇投稿詳細画面/編集処理/削除処理
            Route::get('bulletin_board/post/{id}', [PostsController::class, 'postDetail'])->name('post.detail');
            Route::post('bulletin_board/edit', [PostsController::class, 'postEdit'])->name('post.edit');
            Route::get('bulletin_board/delete/{id}', [PostsController::class, 'postDelete'])->name('post.delete');

            //◇コメント作成処理/投稿へのいいね処理/投稿へのいいね取り消し処理
            Route::post('comment/create', [PostsController::class, 'commentCreate'])->name('comment.create');
            Route::post('like/post/{id}', [PostsController::class, 'postLike'])->name('post.like');
            Route::post('unlike/post/{id}', [PostsController::class, 'postUnLike'])->name('post.unlike');
        });

        //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        // ▮ プロフィール関連
        //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        Route::namespace('Users')->group(function(){

            //◇ユーザ検索画面/ユーザプロフィール画面/プロフィール編集画面
            Route::get('show/users', [UsersController::class, 'showUsers'])->name('user.show');
            Route::get('user/profile/{id}', [UsersController::class, 'userProfile'])->name('user.profile');
            Route::post('user/profile/edit', [UsersController::class, 'userEdit'])->name('user.edit');
        });
    });
});
