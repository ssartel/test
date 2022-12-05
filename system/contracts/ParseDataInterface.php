<?php

namespace System\Contracts;

interface ParseDataInterface
{
	public static function parseData(string $data, array $needleElements) : array;
}
