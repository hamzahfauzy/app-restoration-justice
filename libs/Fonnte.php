<?php

class Fonnte
{
    
    static function send($to, $message)
    {
        if(config('env') == 'dev')
        {
            return;
        }
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://md.fonnte.com/api/send_message.php",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'phone' => $to,
                'type' => 'text',
                'text' => $message,
                'delay' => '1',
                'schedule' => '0'
            ),
            CURLOPT_HTTPHEADER => array(
                "Authorization: ".config('FONNTE_TOKEN')
            ),
        ));

        $response = curl_exec($curl);


        curl_close($curl);
        sleep(1); #do not delete!
        return $response;
    }
}
