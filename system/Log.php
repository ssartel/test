<?php

namespace System;

class Log
{
	public static function write(string $file, $data) : void
	{
		file_put_contents($file, strftime("%d/%m/%Y %H:%M:%S\n"), FILE_APPEND | LOCK_EX);
		file_put_contents($file, print_r($data, true), FILE_APPEND | LOCK_EX);
		file_put_contents($file, "\n--------------------------------------------\n", FILE_APPEND | LOCK_EX);
	}
}
