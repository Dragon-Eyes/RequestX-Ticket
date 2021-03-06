<?php

class Mail {

    public $recipient;
    public $replyto;
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
            $responseObject = json_decode($response);
            $token = $responseObject->response->token;
            return $token;
        }
    }

    private function apiConnectionClose($apikey) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => API_MAIL_URLBASE . "/sessions/" . $apikey,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_RETURNTRANSFER => true,
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
        return;
    }

    public function send() {
        $apikey = $this->apiConnectionOpen();

        // create record
        $curl = curl_init();
        $bodytext = str_replace("\n", "\\n", $this->body);
        $bodytext = str_replace("\r", "", $bodytext);
        $bodytext = str_replace("\"", "\\\"", $bodytext);
        $clientsystem = "ReqX Ticket - " . PROJECT;

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://intra.dragoneyes.solutions/fmi/data/v1/databases/CUBApost/layouts/mail/records",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
        // TODO: escape special characters
            CURLOPT_POSTFIELDS => "{\"fieldData\": {\"ClientSystem\": \"$clientsystem\", \"Recipient\": \"$this->recipient\", \"ReplyTo\": \"$this->replyto\", \"Subject\": \"$this->subject\", \"Body\": \"$bodytext\" } }",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "cache-control: no-cache",
                "Authorization: Bearer $apikey"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $responseObject = json_decode($response);
            $error = $responseObject->message->code;
        }
        if($error == 0) {
            // trigger send-script
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://intra.dragoneyes.solutions/fmi/data/v1/databases/CUBApost/layouts/mail/script/send_mail",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_POSTFIELDS => "",
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "cache-control: no-cache",
                    "Authorization: Bearer $apikey"
                ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $responseObject = json_decode($response);
                $error = $responseObject->message->code;
            }
            if($error == 0) {
                $_SESSION['message'] = 'Die Benachrichtigung an ' . $this->recipient . ' wurde verschickt.';
            } else {
                $_SESSION['message'] = 'Die Benachrichtigung an ' . $this->recipient . ' konnte NICHT verschickt werden (send).';
            }
        } else {
            $_SESSION['message'] = 'Die Benachrichtigung an ' . $this->recipient . ' konnte NICHT verschickt werden (create).';
        }


        $this->apiConnectionClose($apikey);
    }
}