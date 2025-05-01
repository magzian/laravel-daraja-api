<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MpesaController extends Controller
{
    public function getAccessToken(){
        $url = env('MPESA_ENV') == 0 ? 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials' : 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $curl = curl_init($url);

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_HTTPHEADER => ['Content-Type:application/json; charset=utf-8'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false,
                CURLOPT_USERPWD => env('MPESA_CONSUMER_KEY') . ':' . env('MPESA_CONSUMER_SECRET'),
            )
            );

            dd([
                'key' => env('MPESA_CONSUMER_KEY'),
                'secret' => env('MPESA_CONSUMER_SECRET'),
                'url' => env('MPESA_URL'),
            ]);

            $response = curl_exec($curl);
            curl_close($curl);

            // Decode the response string into an array
            $data = json_decode($response, true);

            
            // Return it as a proper JSON response
            return response()->json($data);
    }

    
}
