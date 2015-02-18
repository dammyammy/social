<?php 

namespace Dammyammy\Social;

use Guzzle\Http\Client;
use Dammyammy\Social\Exceptions\CouldNotConnect;
use Dammyammy\Social\Exceptions\MessageNotSpecified;
use Dammyammy\Social\Exceptions\CharactersExceeded;
use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\TwitterOAuthException;

class Twitter implements Social {

	private function authenticate($account)
	{
		$config = useTwitterCredentialsOf($account);

		return new TwitterOAuth($config['CONSUMER_KEY'], $config['CONSUMER_SECRET'], $config['ACCESS_TOKEN'], $config['ACCESS_SECRET']);
	}

	public function post($msg = 'Getting My Hands Wet Again! #Developer', $account = 'evc')
	{
		try
		{
			if (is_null($msg) || $msg == '') throw new MessageNotSpecified;

			if (strlen($msg) > 140) 
			{
				$msgs = wordwrap($msg, 136, "<|>");
				$messages = explode("<|>", $msgs);

				$this->postMultiple($messages, $account);

				return json_encode([
					'status' => 'success', 
					'messages' => $messages, 
					'info' => 'Message Successfully Posted As ' . count($messages) . ' Tweets!! '
				]);
			}

			$response = $this->tweet($msg, $account);


			if (isset($response->errors))
			{
				return json_encode([
					'status' => 'error', 
					'message' => $response->errors[0]->message, 
					'info' => 'Twitter Error Code: ' . $response->errors[0]->code
				]);
			}
			

			return json_encode([
				'status' => 'success', 
				'message' => $response->text, 
				'info' => 'Message Successfully Posted!! '
			]);

		}
		catch(TwitterOAuthException $e)
		{
			throw new CouldNotConnect;
		}
		catch(\RuntimeException $e)
		{

			$errorMsg = substr($e->getMessage(), 0, 29) . '(s)' . substr($e->getMessage(), 59);

			return json_encode([
				'status' => 'error', 
				'message' => 'Authentication Parameters Not Provided', 
				'info' => 'Provide ' . $errorMsg . ' in the .env file in the project root. If None Create the file'
			]);
		}
	}

	public function postMultiple($messages = [], $account)
	{
		$response = [];

		foreach ($messages as $key => $message) 
		{
			$message = (count($messages) > $key + 1) ? $message . '...' : $message; 	
			
			$response[$key] = $this->tweet($message, $account);
		}

		return $response;
	}

	protected function tweet($msg, $account)
	{
		$twitter = $this->authenticate($account);

		return $twitter->post('statuses/update', array('status' => trim($msg) ));
	}

	protected function searchTweets($q, $account)
	{
		$twitter = $this->authenticate($account);

		return $twitter->get('search/tweets', array('q' => urlencode($q) ));
	}

	public function readTweets($screen_name, $account, $limit)
	{
		$twitter = $this->authenticate($account);

		return $twitter->get('statuses/user_timeline', array('screen_name' => trim($screen_name), 'count' => $limit  ));
	}

	public function getMentions($account, $limit, $date = null)
	{
		$date = (is_null($date)) ? mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"))
								 : $date;

		$twitter = $this->authenticate($account);

		return $twitter->get('statuses/mentions_timeline', array('since_id' => $date, 'count' => $limit ));;
	}

	public function rateLimitStatus($account, $resources = 'help,users,search,statuses')
	{

		$twitter = $this->authenticate($account);

		return $twitter->get('application/rate_limit_status', array('resources' => $resources));;
	}

	public function getTimeline($account)
	{
		$twitter = $this->authenticate($account);

		return $twitter->get('statuses/home_timeline');
	}

	public function getRetweets($account)
	{
		$twitter = $this->authenticate($account);

		return $twitter->get('statuses/retweets_of_me');
	}

}