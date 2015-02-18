<?php

require "vendor/autoload.php";

try 
{
	Dotenv::load(__DIR__ . '../../../../..');
} 
catch(\InvalidArgumentException $e){
	
	echo json_encode([
		'status' => 'error', 
		'message' => '.env File Doesn\'t Exist!, create one at project root.', 
		'info' => substr($e->getMessage(), 0, -13) . '.env'
	]);

	die();
}



function useTwitterCredentialsOf($account = 'EVC')
{

	$accounts = explode(',', getenv('TWITTER_ACCOUNTS'));

	foreach ($accounts as $key => $a) {

		Dotenv::required(
			array(
				strtoupper($a) . '_TWITTER_CONSUMER_KEY', 
				strtoupper($a) . '_TWITTER_CONSUMER_SECRET', 
				strtoupper($a) . '_TWITTER_ACCESS_TOKEN', 
				strtoupper($a) . '_TWITTER_ACCESS_SECRET', 
			)
		);

		switch (strtolower($account)) {
			
			case strtolower($a):

				return array(
					'CONSUMER_KEY' => getenv($a . '_TWITTER_CONSUMER_KEY'),
				 	'CONSUMER_SECRET' =>  getenv($a . '_TWITTER_CONSUMER_SECRET'), 
				 	'ACCESS_TOKEN' => getenv($a . '_TWITTER_ACCESS_TOKEN'), 
				 	'ACCESS_SECRET' => getenv($a . '_TWITTER_ACCESS_SECRET')
				);

			break;

		}
	}
}



function useFacebookCredentialsOf($account = 'EVC')
{

	$accounts = explode(',', getenv('FACEBOOK_APPS'));

	foreach ($accounts as $key => $a) {

		Dotenv::required(
			array(
				strtoupper($a) . '_FACEBOOK_APP_ID', 
				strtoupper($a) . '_FACEBOOK_API_SECRET', 
				strtoupper($a) . '_FACEBOOK_ACCESS_TOKEN', 
				strtoupper($a) . '_FACEBOOK_ACCESS_SECRET', 
			)
		);

		switch (strtolower($account)) {
			
			case strtolower($a):

				return array(
					'CONSUMER_KEY' => getenv($a . '_FACEBOOK_APP_ID'),
				 	'CONSUMER_SECRET' =>  getenv($a . '_FACEBOOK_API_SECRET'), 
				 	'ACCESS_TOKEN' => getenv($a . '_FACEBOOK_ACCESS_TOKEN'), 
				 	'ACCESS_SECRET' => getenv($a . '_FACEBOOK_ACCESS_SECRET')
				);

			break;

		}
	}
}