<?php

namespace Dammyammy\Social;

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\GraphPage;
use Facebook\FacebookRequestException;
use GuzzleHttp\Client;



class Facebook implements Social{

	public function post($account = null)
	{
		FacebookSession::setDefaultApplication(getenv('EVC_FACEBOOK_APP_ID'),getenv('EVC_FACEBOOK_APP_SECRET'));

		$client = new Client();
   
  		$client->setDefaultOption('verify', false);

		$res = $client->get('https://graph.facebook.com/v2.2/oauth/access_token', [ 'query' => [
			'client_id' =>  getenv('EVC_FACEBOOK_APP_ID'), 
			'client_secret' =>  getenv('EVC_FACEBOOK_APP_SECRET'),
			'grant_type' => 'client_credentials'
		]]);

		$access_token = substr($res->getBody(), 13);
		
		// var_dump($access_token);
		// die();
		$session = new FacebookSession($access_token);

		// Get the GraphUser object for the current user:

		// try {
		// 
			$graphObject = (new FacebookRequest(
			    $session, 'GET', '/me/accounts'
			))->execute()->getGraphObject();

			
			// $graphObject = (new FacebookRequest(
			//     $session, 'GET', '/' . getenv("EVC_FACEBOOK_APP_ID")
			// ))->execute()->getGraphObject();


		// $graphObject = (new FacebookRequest(
		//     $session, 'POST', '/' . getenv("EVC_FACEBOOK_PAGE_ID") . '/feed', array(
		//     	// 'link' => '',
		//     	'message' => 'President Goodluck Jonathan hosted the eight presidential media chat, since May 2011, talks on Security, Elections and debunks rumours #EVC'
		//     )
		// ))->execute()->getGraphObject(GraphPage::className());
		
		var_dump($graphObject);
		// } 
		// catch (FacebookRequestException $e) {} 
		// catch (\Exception $e) {}
	}

	public function download($filename = null)
	{
	 	$path = 'Jerseys/' . $filename;

	 	if($this->jerseyIsAvailable($filename, $path)) 

	 	$this->downloadJersey($filename, $path);
	}
}