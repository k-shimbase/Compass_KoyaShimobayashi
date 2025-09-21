<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Carbon\Carbon;
use DB;

use App\Models\Users\Subjects;
use App\Models\Users\User;

use App\Http\Requests\Auth\RegisterRequest;

class RegisteredUserController extends Controller
{
    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    // ◆登録画面(GET) | registerView
    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    public function create()
    {
        $subjects = Subjects::all();
        return view('auth.register.register', compact('subjects'));
    }

    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    // ◆登録処理(POST) | registerPost
    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    public function store(RegisterRequest $request) {

        //◆日付取得
        $year = $request->old_year;
        $month = $request->old_month;
        $day = $request->old_day;

        //◆存在しない日付か否かの確認(checkdate()関数で確認)
        if (checkdate($month, $day, $year) === false) {
            return back()->withInput()->withErrors(['old_day' => '正しい日付を記入してください。']);
        }

        //◆指定生年月日と今日の日付をCarbonインスタンスとして定義
        $birth = Carbon::createFromDate($year, $month, $day);
        $today = Carbon::today();

        //◆CarbonクラスのisAfter()関数で指定生年月日が今日よりも未来であるか否かを確認する
        if ($birth->isAfter($today)) {
            return back()->withInput()->withErrors(['old_day' => '生年月日は今日以前で記入してください。']);
        }

        // ◆データ追加処理
        DB::beginTransaction();

        try{
            $birth_day = $birth->toDateString(); //Carbonクラスの関数(日付の文字列型化)
            $subjects = $request->subject;

            $user_get = User::create([
                'over_name' => $request->over_name,
                'under_name' => $request->under_name,
                'over_name_kana' => $request->over_name_kana,
                'under_name_kana' => $request->under_name_kana,
                'mail_address' => $request->mail_address,
                'sex' => $request->sex,
                'birth_day' => $birth_day,
                'role' => $request->role,
                'password' => Hash::make($request->password)
            ]);

            if($request->role == 4){
                $user = User::findOrFail($user_get->id);
                $user->subjects()->attach($subjects);
            }

            //◇クエリ承認
            DB::commit();
            return view('auth.login.login');

        }catch(\Exception $e){

            //◇エラーが発生した際はロールバックする
            DB::rollback();
            return redirect()->route('loginView');
        }
    }
}
