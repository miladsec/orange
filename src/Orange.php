<?php


namespace MiladZamir\Orange;


use Illuminate\Support\Facades\Http;

class Orange
{
    public static function smsSend(array $receptor, string $message, int $sender = null, int $date = null, string $type = null, string $localid = null, bool $hide = null, bool $debug = false)
    {
        $receptor = implode(',', $receptor);
        $message = urlencode($message);
        $BasicUrl = self::getBaseApiUrl() . self::getApiToken() . self::getMethodApiUrl('sms', 'send');

        $client = Http::post($BasicUrl .
            "receptor=" . $receptor .
            "&message=" . $message .
            "&sender=" . $sender
        );

        $result = $client->json();

        if ($debug == true)
            return $client->json();
        elseif ($result['return']['status'] == 200) {
            try {
                self::storeSmsLog($result);
            }catch (\Exception $e){
                return false;
            }
            return response()->json(['status' => 200]);
        }

        try {
            self::storeSmsLog($result , true);
        }catch (\Exception $e){
            return false;
        }

        return response()->json(['status' => 422]);
    }

    public static function smsLookup(string $receptor, string $token, string $token2 = null, string $token3 = null, string $template, string $type = null, bool $debug = false)
    {
        $BasicUrl = self::getBaseApiUrl() . self::getApiToken() . self::getMethodApiUrl('verify', 'lookup');
        $client = Http::post($BasicUrl .
            "receptor=" . $receptor .
            "&token=" . $token .
            "&token2=" . $token2 .
            "&token3=" . $token3 .
            "&template=" . $template
        );
        $result = $client->json();

        if ($debug == true)
            return $client->json();
        elseif ($client->json()['return']['status'] == 200) {
            try {
                self::storeSmsLog($result);
            }catch (\Exception $e){
                return false;
            }
            return response()->json(['status' => 200]);
        }

        try {
            self::storeSmsLog($result , true);
        }catch (\Exception $e){
            return false;
        }

        return response()->json(['status' => 422]);
    }

    public static function smsReceive(string $linenumber, bool $isread, bool $debug = false)
    {
        if ($isread == true)
            $isread = 1;
        else
            $isread = 0;

        $BasicUrl = self::getBaseApiUrl() . self::getApiToken() . self::getMethodApiUrl('sms', 'receive');


        $client = Http::post($BasicUrl .
            "linenumber=" . $linenumber .
            "&isread=" . $isread
        );

        if ($debug == true) {
            return $client->json();
        } elseif ($client->json()['return']['status'] == 200) {
            return $client->json()['entries'];
        }

        return response()->json(['status' => 422]);

    }

    private static function getBaseApiUrl()
    {
        return 'https://api.kavenegar.com/v1/';
    }

    private static function getApiToken()
    {
        return config('orange.api_key');
    }

    private static function getMethodApiUrl($method, $type)
    {
        return '/' . $method . '/' . $type . '.json?';
    }

    private static function storeSmsLog($result, bool $failed = false)
    {
        if ($failed != false){
            \MiladZamir\Orange\Models\Orange::create([
                'status' => $result['return']['status'],
                'result_message' => $result['return']['message'],
            ]);
            return true;
        }
        foreach ($result['entries'] as $value){
            \MiladZamir\Orange\Models\Orange::create([
                'status' => $result['return']['status'],
                'result_message' => $result['return']['message'],
                'message_id' => $value['messageid'],
                'message' => $value['message'],
                'status_entries' => $value['status'],
                'status_text' => $value['statustext'],
                'sender' => $value['sender'],
                'receptor' => $value['receptor'],
                'date' => $value['date'],
                'cost' => $value['cost'],
            ]);
        }

        return true;
    }

}
