<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Uniquepaybdapi {

    /**
     *
     * Define Payment && Create payment.
     * 
     */
    public function payment($data = "",$header='') {
        
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
            'app-key: ' . $header['api'],
            'secret-key: ' . $header['secret'],
            'host-name: ' . $header['position'],
        );
        $url = $header['url'];
        $curl = curl_init();
        $data = http_build_query($data);
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_VERBOSE =>true
        ));
         
        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }


       
}

