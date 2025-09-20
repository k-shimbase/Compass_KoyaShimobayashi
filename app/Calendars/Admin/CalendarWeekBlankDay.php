<?php
namespace App\Calendars\Admin;

//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// ◆Admin階層
//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
class CalendarWeekBlankDay extends CalendarWeekDay{

  function getClassName(){
    return "day-blank";
  }

  function render(){
    return '';
  }

  function everyDay(){
    return '';
  }

  function dayPartCounts($ymd = null){
    return '';
  }

  function dayNumberAdjustment(){
    return '';
  }
}
