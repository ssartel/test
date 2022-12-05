<?php

namespace System;

use RuntimeException;
use SplFileInfo;
use System\Exceptions\InvalidParamException;

class File
{
	public static function findFiles(string $dir) : array
	{
		$dir = self::checkDir($dir);
		$list = [];
		$handle = self::openDir($dir);

		while (($file = readdir($handle)) !== false) {

			if ($file === '.' || $file === '..') {
				continue;
			}

			$path = $dir . '/' . $file;
			$path = str_replace('\\', '/', $path);

			if (is_file($path)) {
				$info = new SplFileInfo($path);

				$list[] = [
					'path' => $path,
					'extension' => $info->getExtension(),
					'name' => str_replace('.' . $info->getExtension(), '', $file)
				];
			}
		}

		closedir($handle);

		return $list;
	}

	private static function checkDir(string $dir) : string
	{
		if (!is_dir($dir)) {
			throw new InvalidParamException("The dir argument must be a directory: $dir");
		}
		return rtrim($dir);
	}

	private static function openDir(string $dir)
	{
		$handle = opendir($dir);

		if ($handle === false) {
			throw new InvalidParamException("Unable to open directory: $dir");
		}

		return $handle;
	}
	public static function generateDir(array $path = []) : string
	{
		$fullPath = LOG_PATH;
		self::createDir($fullPath);

		foreach ($path as $dirName) {
			$fullPath .= '/' . $dirName;
			self::createDir($fullPath);
		}

		return $fullPath;
	}

	public static function createDir($dir) : void
	{
		if (!is_dir($dir) && !mkdir($dir, 0775) && !is_dir($dir)) {
			throw new RuntimeException("Directory $dir was not created");
		}
	}
}
