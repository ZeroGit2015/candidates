<?php 
//************************************************
// Класс дополнительных функций	системы
//************************************************
namespace App\Classes;

use DB;
use Session;
use Config;


final class A {



	// Конструктор
	public function __construct()
	{
	}


    //*********************************************************************************
    // Время из формата ДД-ММ-ГГГГ ЧЧ:ММ в MySQL формат(ГГГГ-ММ-ДД ЧЧ:ММ)
    // $separator - входной разделитель, 
    // $line2   - разделить <br/> дату и время
    //*********************************************************************************
    static function to_dt_mysql($dt, $separator='.', $line2=FALSE) {
  
     $result = "";
  
     if ($dt) {
      $arr_dt   = explode(" ",trim($dt));
      $time     = (isset($arr_dt[1]) ? $arr_dt[1] : "");
      $arr_date = explode($separator, $arr_dt[0]);
  
      $date = '';
      if (($arr_dt[0]!="00{$separator}00{$separator}0000")and($arr_dt[0])) {
       $date = "{$arr_date[2]}-{$arr_date[1]}-{$arr_date[0]}";
      }

      if ((int) trim(str_replace(":","",$time))==0) {
       $time = '';
      }
  
      $result = $date.($time ? ($line2 ? "<br/>" : " ").$time : "");
     }
  
     return $result;
    }
  
  
  
    //*********************************************************************************
    // Время из формата ГГГГ-ММ-ДД ЧЧ:ММ в MySQL формат(ДД-ММ-ГГГГ ЧЧ:ММ)
    // $separator - входной разделитель, 
    // $line2   - разделить <br/> дату и время
    //*********************************************************************************
    static function to_dt_ru($dt, $separator='-', $line2=FALSE) {
  
     $result = "";
  
     if ($dt) {
      $arr_dt   = explode(" ",trim($dt));
      $time     = (isset($arr_dt[1]) ? $arr_dt[1] : "");
      $arr_date = explode($separator, $arr_dt[0]);
      
      $date = '';
      if (($arr_dt[0]!="0000{$separator}00{$separator}00")and($arr_dt[0])) {
       $date = "{$arr_date[2]}.{$arr_date[1]}.{$arr_date[0]}";
      }

      if ((int) trim(str_replace(":","",$time))==0) {
       $time = '';
      }

      $result = $date.($time ? ($line2 ? "<br/>" : " ").$time : "");
     }
  
     return $result;
    }


}