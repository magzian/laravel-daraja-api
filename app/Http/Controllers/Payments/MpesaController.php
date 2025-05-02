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

                 // 👇 Add this line to skip SSL certificate validation
                CURLOPT_SSL_VERIFYPEER => false,
            )
            );

            

            $response = curl_exec($curl);


            if (curl_errno($curl)) {
                dd('cURL Error', curl_error($curl));
            }
            
            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            
            /* dd([
                'http_code' => $http_code,
                'raw_response' => $response,
            ]); */

            // Decode the response string into an array
            $data = json_decode($response, true);

           /*  dd([
                'http_code' => $http_code,
                'decoded_data' => $data,
            ]); */
            
            // Return it as a proper JSON response
            return response()->json($data);

            

            
    } 

    

    
}
