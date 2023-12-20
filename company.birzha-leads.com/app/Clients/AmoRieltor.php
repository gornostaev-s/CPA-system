<?php

namespace App\Clients;

class AmoRieltor
{
    public function getObjects()
    {
        $apiToken = "29198023-ad2bbd06-c6ad-4dae-a92a-067364766b60";
        $apiBaseUrl = "https://api.amorealtor.ru";

        $query = [
            'with' => 'files,descriptions,params,category,responsible,deal_type'
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiBaseUrl . "/objects/?" . http_build_query($query),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Api " . $apiToken
            )
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        return json_decode($response, true);
    }

    public function getObject(int $id)
    {
        $apiToken = "29198023-ad2bbd06-c6ad-4dae-a92a-067364766b60";
        $apiBaseUrl = "https://api.amorealtor.ru";

        $query = [
            'with' => 'files,descriptions,params'
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiBaseUrl . '/objects/' . $id . '?' . http_build_query($query),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Api " . $apiToken
            )
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        return json_decode($response, true);
    }
}