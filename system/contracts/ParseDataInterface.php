<?php

namespace System\Contracts;

interface ParseDataInterface
{
	public function parseData(string $data, array $needleElements) : array;
}
