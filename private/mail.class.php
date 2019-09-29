<?php

class Mail {

    public $recipient;
    public $subject;
    public $body;

    private function apiConnectionOpen() {
        $authorization = base64_encode(API_MAIL_USER . ':' . API_MAIL_PASSWORD);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => API_MAIL_URLBASE . "/sessions",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Basic $authorization"
            ),
            CURLOPT_POSTFIELDS => "{}"
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            // print_r($response); echo "<hr>";
            $responseObject = json_decode($response);
            $token = $responseObject->response->token;
            // echo $token;
            return $token;
        }
    }

    private function apiConnectionClose($apikey) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => API_MAIL_URLBASE . "/sessions/" . $apikey,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            // CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
        ));
        curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        }
    }

    public function send() {
        $apikey = $this->apiConnectionOpen();
        // create record
        // trigger send-script
        $this->apiConnectionClose($apikey);
        exit();
    }
}