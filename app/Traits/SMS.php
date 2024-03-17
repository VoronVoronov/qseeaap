<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

trait SMS
{

    /**
     * @throws GuzzleException
     */
    public function smsCenter($phone, $message): int
    {
        $url = 'https://smsc.kz/rest/send/';
        $client = new Client();
        $response = $client->request('POST', $url, [
            'json' => [
                'login' => env('SMSC_LOGIN'),
                'psw' => env('SMSC_PASSWORD'),
                'sender' => env('SMSC_SENDER'),
                'phones' => $phone,
                'mes' => $message,
                'translit' => 1,
                'charset' => 'utf-8',
            ]
        ]);
        $result = json_decode($response->getBody()->getContents());
        if(isset($result->id)) {
            return $result->id;
        }
        return 0;
    }

    /**
     * @throws GuzzleException
     */
    public function Mobizon($phone, $message): int
    {
        $url = 'https://api.mobizon.kz/service/message/SendSmsMessage?output=json&api=v1&apiKey='.env('MOBIZON_API_KEY');
        $client = new Client();
        $response = $client->request('POST', $url, [
            'form_params' => [
                'recipient' => $phone,
                'text' => $message,
            ]
        ]);
        $result = json_decode($response->getBody()->getContents());
        if(isset($result->data->messageId)){
            return $result->data->messageId;
        }
        return 0;
    }

}
