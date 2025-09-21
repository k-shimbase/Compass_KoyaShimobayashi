<?php

namespace App\Http\Controllers\Authenticated\Calendar\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\Admin\CalendarView; //◇Admin CalendarViewクラスのuse
use App\Calendars\Admin\CalendarSettingView; //◇Admin CalendarSettingViewクラスのuse
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Carbon\Carbon;
use Auth;
use DB;

class CalendarsController extends Controller
{
    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    // ◆スクール予約確認画面(GET) | calendar.admin.show
    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    public function show(){

        //◆Admin CalendarViewのインスタンス
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.admin.calendar', compact('calendar'));
    }

    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    // ◆スクール予約詳細画面(GET) | calendar.admin.detail
    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    public function reserveDetail($date, $part){

        //◇対象日付/パートのidに属しているユーザ一覧を取得
        $reserveUsers = User::whereHas('reserveSettings', function($where_query) use ($date, $part) {
            $where_query->where('setting_reserve', $date)
            ->where('setting_part', $part);
        })->get();

        $formatted_date = Carbon::parse($date)->format('Y年m月d日');
        return view('authenticated.calendar.admin.reserve_detail', compact('reserveUsers', 'formatted_date', 'part'));
    }

    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    // ◆スクール枠登録(GET) | calendar.admin.setting
    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    public function reserveSettings(){

        //◆Admin CalendarSettingViewのインスタンス
        $calendar = new CalendarSettingView(time());
        return view('authenticated.calendar.admin.reserve_setting', compact('calendar'));
    }

    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    // ◇スクール枠登録更新処理(POST) | calendar.admin.update
    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    public function updateSettings(Request $request){
        $reserveDays = $request->input('reserve_day');
        foreach($reserveDays as $day => $parts){
            foreach($parts as $part => $frame){
                ReserveSettings::updateOrCreate([
                    'setting_reserve' => $day,
                    'setting_part' => $part,
                ],[
                    'setting_reserve' => $day,
                    'setting_part' => $part,
                    'limit_users' => $frame,
                ]);
            }
        }
        return redirect()->route('calendar.admin.setting', ['user_id' => Auth::id()]);
    }
}
