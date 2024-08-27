<?php

namespace App\Helpers;

class GlobalHelper
{
    public static function sendOTP($otp, $type, $nomor)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://34.50.89.160:3001/api/v1/messages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                "recipient_type" => "individual",
                "to" => $nomor,
                "type" => "text",
                "text" => [
                    "body" => "#OTP> *$otp* \n\n&#128683 DEMI KEAMANAN JANGAN BERIKAN KODE OTP KEPADA SIAPAPUN (TERMASUK GASJek). \n\n Notes:\n_- Pesan ini dikirim secara otomatis oleh sistem GASJek._\n_- Untuk informasi lebih lanjut silahkan hubungi 0858-9661-7773._"
                ]
            ]),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ukOnFtHEplRfiT7O.FstbrTQ0dNzhsIHaDrgfs3Q4qSQ7rVyw'
            ),
        ));

        // Lakukan request cURL
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public static function sendWhatsApp($nomor, $message)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://34.50.89.160:3001/api/v1/messages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                "recipient_type" => "individual",
                "to" => $nomor,
                "type" => "text",
                "text" => [
                    "body" => $message
                ]
            ]),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ukOnFtHEplRfiT7O.FstbrTQ0dNzhsIHaDrgfs3Q4qSQ7rVyw'
            ),
        ));

        // Lakukan request cURL
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}
