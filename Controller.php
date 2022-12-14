<?php

declare(strict_types=1);

use System\CURL;
use System\Data;
use System\Exceptions\InvalidParamException;
use System\File;
use System\Log;

class Controller
{
    protected Data $data;
    public string $logPath = '';

    public function __construct(Data $data)
    {
        $this->data = $data;
    }

    public function handleResponse() : void
    {
        if (empty($this->data->formattedData)) {
            throw new InvalidParamException('empty data array');
        }

        if (empty($this->logPath)) {
            $logPathArray = [date('Y'), date('m'), date('d')];
            $logFileName = date('H-i');

            $this->logPath = File::generateDir($logPathArray) . $logFileName . '.txt';
        }

        foreach ($this->data->formattedData as $data) {
            krsort($data);

            foreach ($data as $roundPart => $roundData) {
                $RequestType = $roundPart . '_round';

                $dataToSend = $data[$roundPart];
                $dataToSend['provider_id'] = PROVIDER_ID;
                $dataToSend['sign'] = $this->generateSign(json_encode($dataToSend));

                $response = json_decode($this->sendRequest(API_URL . $RequestType, $dataToSend));

                $dataToLog = [
                    'request_type' => $RequestType,
                    'round_id' => $data[$roundPart]['round_id'],
                    ];

                if (!$response) {
                    $dataToLog['error_message'] = 'incorrect answer';
                } else {
                    $dataToLog += [
                        'success' => (bool)$response->success,
                        'error_message' => $response->success ? '' : $response->message,
                        'action_id' => $response->success ? $response->action_id : '',
                    ];
                }

                Log::write($this->logPath, $dataToLog);
            }
        }
    }

    public function sendRequest(string $url, array $data) : string
    {
        $curl = new CURL($url);
        $curl->setHeaders(["Content-Type: application/json"]);
        $curl->setPost($data);
        $curl->addParams([CURLOPT_TIMEOUT => 3]);
        $curl->send();

        return $curl->getResponseData();
    }

    public function generateSign(string $data) : string
    {
        return hash_hmac('sha256', $data, HMAC_KEY);
    }
}
