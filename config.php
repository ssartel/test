<?php
const ROUND_SEPARATOR = '_round_';
const START_CALL = 'start';
const END_CALL = 'end';

const DIR_STORAGE = 'storage/';
const LOG_PATH = DIR_STORAGE . 'log';
const REQUESTS_PATH = DIR_STORAGE . 'requests';

const PROVIDER_ID = 96714;
const HMAC_KEY = 'fndZ7iMhxdJeuOmnh3DlJXXMLrwjblC1pHXa8pZt';

const API_URL = 'https://int.dev.onlyplay.net/test_api/';

$params = [
	'dataTemplate' => [
		START_CALL =>[
			'round_id' => [
				'json' => 'roundId',
				'xml' => 'round-id',
			],
			'player_id' => [
				'json' => 'playerId',
				'xml' => 'player-id',
			]
		],
		END_CALL =>[
			'round_id' => [
				'json' => 'roundId',
				'xml' => 'round-id',
			],
			'reward' => [
				'json' => 'reward',
				'xml' => 'reward',
			]
		],
	]
];
