<?php

namespace App\Http\Controllers\Android;

// use App\Jobs\SendFcmNotif;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NotificationController extends Controller
{
    
    public function sendNotification(Request $request)
    {
        // $notif = new SendFcmNotif();
        // $this->dispatch($notif);
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $token = "AAAA8ebM3Q4:APA91bGAAWqa0LIQbZE-SsGZVx6MueJ32LafTle6nR6TEN91sBX8vnnQsqC6ym1M_B3XLSsG1tZtdNQ1U0WSoTnW-kBxxtzi0RwsWYsPToHppMuNThBUJaBPwz0CnXGE4klI7HTCnnIr";

        $notification = [
            'tipeNotifikasi' => "presensi",
            'pegawaiId' => $request->id_pegawai,
            'waktuPresensi' => Carbon::now(),
            'tipePegawai' => $request->tipePegawai,
            'tipePresensi' => $request->tipePresensi
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
        return response()->json($response);
    }

}
