<?php

function debug ($data, $isExit = false)
{
	echo "<pre>";
	print_r($data);
	echo "</pre>";

	if($isExit)
	{
		exit;
	}
}