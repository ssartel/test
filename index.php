<?php

declare(strict_types=1);

include_once('debug.php');
include_once('config.php');
include_once('init.php');

use System\Data;
use System\Exceptions\InvalidParamException;

try {
	$data = new Data(REQUESTS_PATH, $params['dataTemplate']);
	$data->formatData();

	$controller = new Controller($data);
	$controller->handleResponse();
} catch (InvalidParamException $e) {
	echo $e->getMessage();
} catch (Throwable $e) {
	echo $e->getMessage();
}

echo 'All requests are send.';
