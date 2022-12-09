<?php

declare(strict_types=1);

namespace System;

use System\Exceptions\InvalidParamException;
use System\Data\ParserSelector;

class Data
{
	public array $formattedData = [];
	protected array $filesList;
	protected string $dirPath;
	protected array $dataTemplate;

	public function __construct(string $dirPath, array $dataTemplate)
	{
		$this->dirPath = $dirPath;
		$this->dataTemplate = $dataTemplate;
	}

	public function getFilesList() : void
	{
		$list = File::findFiles($this->dirPath);

		if (empty($list)) {
			throw new InvalidParamException('empty files list');
		}

		$this->filesList = $list;
	}

	public function formatData() : void
	{
		$this->getFilesList();

		$formattedData = [];

		foreach ($this->filesList as $file) {
			$data = file_get_contents($file['path']);

            $parser = ParserSelector::getParser($file['extension']);

			$explode = explode(ROUND_SEPARATOR, $file['name']);

			if (empty($data) || !isset($explode[1])) {
				break;
			}

			$round = $explode[1];
			$endPoint = $explode[0];

			$formattedData[$round][$endPoint] = $parser->parseData($data, $this->dataTemplate[$endPoint]);
		}
		
		$this->formattedData = $formattedData;
	}
}
