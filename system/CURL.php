<?php

declare(strict_types=1);

namespace System;

use System\Exceptions\InvalidParamException;

class CURL
{
	protected string $url;
	protected bool $isPost = false;
	protected bool $isGet = false;
	protected array $params = [];
	protected array $requestData = [];
	protected string $responseData = '';
	protected array $curlInfo = [];

	public function __construct(string $url)
	{
		$this->url = $url;
		$this->addParams([CURLINFO_HEADER_OUT => true, CURLOPT_RETURNTRANSFER => true]);
	}

	public function setHeaders(array $headers) : void
	{
		$this->addParams([
			CURLOPT_HTTPHEADER => $headers
		]);
	}

	public function setPost(array $params) : void
	{
		if ($this->isGet !== false) {
			throw new InvalidParamException('GET is already set');
		}

		$this->isPost = true;
		$this->addParams([
			CURLOPT_URL => $this->url,
			CURLOPT_POSTFIELDS => json_encode($params, JSON_THROW_ON_ERROR),
			CURLOPT_POST => true,
			]);
	}

	public function setGet(array $params) : void
	{
		if ($this->isPost !== false) {
			throw new InvalidParamException('POST is already set');
		}

		$this->isGet = true;
	    $this->addParams([
			CURLOPT_URL => $this->url . '?' . http_build_query($params),
			CURLOPT_POST => false,
			]);
	}

	public function send() : void
	{
		if (($this->isGet === false) && ($this->isPost === false)) {
			throw new InvalidParamException('params isn`t set');
		}
		
		$ch = curl_init();
		
		foreach ($this->params as $key => $value) {
			curl_setopt($ch, $key, $value);
		}

		$data['requestUrl'] = $this->url;

		$this->requestData  = $data;

        $response  = curl_exec($ch);

        if (is_string($response)) {
            $this->responseData  = $response;
        }

		$this->curlInfo["headers"]     = curl_getinfo($ch, CURLINFO_HEADER_OUT);
		$this->curlInfo["info"]        = curl_getinfo($ch);
		$this->curlInfo["error_nr"]    = curl_errno($ch);
		$this->curlInfo["error_text"]  = curl_error($ch);
		$this->curlInfo["http_status"] = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);
	}

	public function addParams(array $params) : void
	{
		$this->params += $params;
	}

	public function getRequestData() : array
	{
		return $this->requestData;
	}

	public function getResponseData() : string
	{
		return $this->responseData;
	}

	public function getCurlInfo() : array
	{
		return $this->curlInfo;
	}
}
