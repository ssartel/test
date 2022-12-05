<?php

namespace System\Data;

use SimpleXMLElement;
use System\Contracts\ParseDataInterface;

class XML implements ParseDataInterface
{
	public static function parseData(string $data, array $needleElements) : array
	{
		$fullData = [];

		$parsedData = new SimpleXMLElement($data);

		foreach ($needleElements as $key => $value) {
			$fullData[$key] = get_object_vars($parsedData->{$value['xml']})[0];
		}

		return $fullData;
	}
}
