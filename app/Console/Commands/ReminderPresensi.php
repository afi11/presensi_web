<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\WaktuPresensi;

class ReminderPresensi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:reminderpresensi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $waktu = WaktuPresensi::where('hari',getNameDay())->get();
        foreach($waktu as $data){
            if($data->tipe_presensi == "jam_masuk"){
                $this->sendNotification("jam_masuk",substr($data->jam_presensi,0,5));
            } 
            if($data->tipe_presensi == "jam_pulang"){
                $this->sendNotification("jam_pulang",substr($data->jam_presensi,0,5));
            }
        }
    }

    public function sendNotification($tipePresensi, $jam)
    {
        if($jam == getTimeNow()){
            $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
            $token = "AAAA8ebM3Q4:APA91bGAAWqa0LIQbZE-SsGZVx6MueJ32LafTle6nR6TEN91sBX8vnnQsqC6ym1M_B3XLSsG1tZtdNQ1U0WSoTnW-kBxxtzi0RwsWYsPToHppMuNThBUJaBPwz0CnXGE4klI7HTCnnIr";
    
            $notification = [
                'waktuPresensi' => $jam,
                'tipePegawai' => "allPegawai",
                'tipePresensi' => $tipePresensi,
                'tipeNotifikasi' => "presensi",
                'pegawaiId' => "allPegawai"
            ];
    
            // $notificationData = ["message" => $notification,"moredata" =>'dd'];
    
            $fcmNotification = [
                //'registration_ids' => $tokenList, 
                'to' => "/topics/PresensiNotification",
                'data' => $notification
            ];
    
            $headers = [
                'Content-Type: application/json',
                'Authorization: key='.$token,
            ];
    
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$fcmUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
            $response = curl_exec($ch);
            curl_close($ch);
            \Log::info($response);
        }
    }
}
