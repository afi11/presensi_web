<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendFcmNotif implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $token = "AAAA8ebM3Q4:APA91bGAAWqa0LIQbZE-SsGZVx6MueJ32LafTle6nR6TEN91sBX8vnnQsqC6ym1M_B3XLSsG1tZtdNQ1U0WSoTnW-kBxxtzi0RwsWYsPToHppMuNThBUJaBPwz0CnXGE4klI7HTCnnIr";

        $notification = [
            'waktuPresensi' => Carbon::now(),
            'tipePegawai' => "ASN",
            'tipePresensi' => "Jam Masuk"
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
        dd($response);
    }
}
