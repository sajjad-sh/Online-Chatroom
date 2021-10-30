<?php
    date_default_timezone_set("Asia/Tehran");

    function toJalali($gregorian_date) {
      $date = new DateTime($gregorian_date);

      $gy = $date->format('Y');
      $gm = $date->format('m');
      $gd = $date->format('d');

      $now_time = date("H:i:s", time());

      $g_d_m = array(0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334);
      $gy2 = ($gm > 2)? ($gy + 1) : $gy;
      $days = 355666 + (365 * $gy) + ((int)(($gy2 + 3) / 4)) - ((int)(($gy2 + 99) / 100)) + ((int)(($gy2 + 399) / 400)) + $gd + $g_d_m[$gm - 1];
      $jy = -1595 + (33 * ((int)($days / 12053)));
      $days %= 12053;
      $jy += 4 * ((int)($days / 1461));
      $days %= 1461;
      if ($days > 365) {
          $jy += (int)(($days - 1) / 365);
          $days = ($days - 1) % 365;
      }
      if ($days < 186) {
          $jm = 1 + (int)($days / 31);
          $jd = 1 + ($days % 31);
      }
      else{
          $jm = 7 + (int)(($days - 186) / 30);
          $jd = 1 + (($days - 186) % 30);
      }

      return $jy.'-'.$jm.'-'.$jd . ' | ' . $now_time;
  }