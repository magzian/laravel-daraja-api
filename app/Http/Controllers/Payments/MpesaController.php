<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use COM;
use Illuminate\Http\Request;

class MpesaController extends Controller
{
    private function retrieveAccessToken(){
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
            
            $data = json_decode($response); // ← decode as object
            /* dd($data->access_token);   */      // ← access as object property
            return $data->access_token ?? null;
    }

    public function getAccessToken(){
        $token = $this->retrieveAccessToken();
        return response()->json([
            'access_token' => $token,
        ]);

        /* dd($token); */
    }

   

    //Register URLs

    public function registerUrls(){
        $body = array(
            'ShortCode' => env('MPESA_SHORTCODE'),
            'ResponseType' => 'Completed',
            'ConfirmationURL' => env('MPESA_TEST_URL').'/api/confirmation',
            'ValidationURL' => env('MPESA_TEST_URL') . '/api/validation',
        );
        
        $url = env('MPESA_ENV') == 0 ? 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl' : 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl';
        
        $response = $this->makeHttp($url, $body);
        /* dd($response); */
        
        return response()->json(json_decode($response));
    }

    public function makeHttp($url, $body){
        $token = $this->retrieveAccessToken();
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $url,
                CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Authorization:Bearer ' . $token),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($body),
                CURLOPT_SSL_VERIFYPEER => false, // 👈 Add this line to skip SSL certificate validation
            )
        );

        $curl_response = curl_exec($curl);
        curl_close($curl);
        return $curl_response;
    }

    



    

    
}
