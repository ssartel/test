<?php

namespace System\Data;

use System\Contracts\ParseDataInterface;

class JSON implements ParseDataInterface
{
	public static function parseData(string $data, array $needleElements) : array
	{
		$fullData = [];

		foreach ($needleElements as $key => $value) {
			$parsedData = json_decode($data, false, 512, JSON_THROW_ON_ERROR);
			$fullData[$key] = $parsedData->{$value['json']};
		}

		return $fullData;
	}
}
