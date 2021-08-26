<?php

use Carbon\Carbon;

function getDiffTime($date1, $date2){
    $datediff = strtotime($date1) - strtotime($date2);
    return round($datediff / (60));
}

function getNameDay() {
    $now = Carbon::now();
    return $now->format('l');
}

function getTanggal() {
    $date = Carbon::now();
    return $date->format('Y-m-d');
}

function hitungLamaHari($startDate, $endDate)
{
    $tgl1 = new \DateTime($startDate);
    $tgl2 = new \DateTime($endDate);
    $day = $tgl1->diff($tgl2);
    return ($day->format('%a'));
}

function hitungTanggalNegatif($date1, $date2){
    $datediff = strtotime($date1) - strtotime($date2);
    return round($datediff / (60 * 60 * 24));
}

function getTimeNow() {
    return Carbon::now()->format('H:i');
}
