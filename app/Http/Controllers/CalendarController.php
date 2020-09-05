<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\Holiday;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function getHoliday(Request $request)
    {
        // 休日データ取得
        $list = Holiday::all();
        return view('calendar.holiday', ['list' => $list]);        
    }
    public function postHoliday(Request $request)
    {
        // POSTで受信した休日データの登録
        $holiday = new Holiday(); 
        $holiday->day = $request->day;
        $holiday->description = $request->description;        
        $holiday->save();
        // 休日データ取得
        $list = Holiday::all();
        return view('calendar.holiday', ['list' => $list]);
    }

    public function index(Request $request)
    {
        $list = Holiday::all();
        $cal = new Calendar($list);
        $tag = $cal->showCalendarTag($request->month,$request->year);

        return view('calendar.index', ['cal_tag' => $tag]);
    }
}