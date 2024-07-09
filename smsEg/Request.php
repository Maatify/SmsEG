<?php

/**
 * @copyright   ©2024 Maatify.dev
 * @Liberary    SmsEG
 * @Project     SmsEG
 * @author      Mohamed Abdulalim (megyptm) <mohamed@maatify.dev>
 * @since       2024-07-9 2:2 PM
 * @see         https://www.maatify.dev Maatify.com
 * @link        https://github.com/Maatify/smseg  view project on GitHub
 * @link        https://github.com/Maatify/Logger (maatify/logger)
 * @copyright   ©2023 Maatify.dev
 * @note        This Project using for WhySMS Egypt SMS Provider API.
 * @note        This Project extends other libraries maatify/logger.
 *
 * @note        This program is distributed in the hope that it will be useful - WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
 *
 */

namespace Maatify\SmsEG;

use Maatify\Logger\Logger;

abstract class Request
{
    protected string $url;

    protected string $username;
    protected string $password;
    protected string $sender_name;

    private string $api_url = 'https://smssmartegypt.com/sms/api/';
    public function __construct(string $username,string $password, string $sender_name)
    {
        $this->sender_name = $sender_name;
        $this->username = $username;
        $this->password = $password;
    }
    public function CheckBalance(): array
    {
        $this->url = $this->api_url . "getBalance?username=" . urlencode($this->username) .
                     "&password=" . urlencode($this->password);

        return $this->Curl();
    }

    public function SendSms($to, $message): array
    {
        //        $url = 'https://smssmartegypt.com/sms/api/?username=xxxx&password=xxxx&sendername=xxxx&message=xxxx&mobiles=xxxx,xxxx';
        $this->url = $this->api_url . "?username=" . urlencode($this->username) .
                     "&password=" . urlencode($this->password) .
                     "&sendername=" . urlencode($this->sender_name) .
                     "&message=" . urlencode($message) .
                     "&mobiles=$to,";
        return $this->Curl();

    }

    protected function Curl(array $params = []){
        if(!empty($this->url)) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url);
            if(!empty($params)){
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
            }else{
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            }
            /*
            // no need returns from curl
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, 100);
            */
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_FAILONERROR, true); // Required for HTTP error codes to be reported via our call to curl_error($ch)
            //        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Cache-Control: no-cache',
                'Content-Type: application/json',
            ));
                $result = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $curl_errno = curl_errno($ch);
                $curl_error = curl_error($ch);
                curl_close($ch);

            if ($curl_errno > 0) {
                $response['success'] = false;
                $response['error'] = "(err-" . __METHOD__ . ") cURL Error ($curl_errno): $curl_error";
            } else {
                if ($resultArray = json_decode($result, true)) {
                    $response = $resultArray;
                    $response['success'] = true;
                } else {
                    $response['success'] = false;
                    $response['error'] = ($httpCode != 200) ? "Error header response " . $httpCode : "There is no response from server (err-" . __METHOD__ . ")";
                    $response['result'] = $result;
                }
            }

            if(!empty($response['type']) && $response['type'] == 'error'){
                $response['success'] = false;
            }

            if (empty($response['success']) || empty($response['type']) || $response['type'] !== 'error') {
                Logger::RecordLog([
                    $response,
                    $this->url,
                    $params,
                   __METHOD__], 'Debug_SMSEG_' . __FUNCTION__);
            }

            return $response;
        }
        return ['success' => false];
    }

}