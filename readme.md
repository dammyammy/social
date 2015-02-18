# Social
======

> Domain	=> http://mobilexserver.com
> Port	=> 8989

> BaseUrl => http://mobilexserver.com:8989/utils/social

> Home Page: http://mobilexserver.com:8989/utils/social


## Usage:
======

### Requests
============

To post on twitter Timeline

```
Request Type: 		GET 
Request URL:		http://mobilexserver.com:8989/utils/social/twitter.php

Query String:		msg: 	 	[string] 	[Message to Post on Twitter]
					account: 	[string]	[Account to Tweet to] 		[Optional (evc: default)]

Example Request:	http://mobilexserver.com:8989/utils/social/twitter.php?msg=Dammy+is+the+shit&account=evc
```



To post on Facebook Page

```
Request Type: 		GET 
Request URL:		http://mobilexserver.com:8989/utils/social/facebook.php

Query String:		msg: 	 	[string] 	[Message to Post on Facebook Page]
					page: 		[string]	[Page to Post to] 		[Optional (evc: default)]

Example Request:	http://mobilexserver.com:8989/utils/social/facebook.php?msg=Dammy+is+the+shit&page=evc
```


### Responses
=============

	##### Successful

	A successful Request would give back a json Response with a success status, a message and info.

	> $response['status'] will equal 'success'



	##### Failure

	A failed Request would give back a json Response with an error status, a message and info about the error code returned.

	> $response['status'] will equal 'error'

	
### Exceptions
==============

	1. Dammyammy\Social\Exceptions\MessageNotSpecified
	2. Dammyammy\Social\Exceptions\CouldNotConnect
	3. Dammyammy\Social\Exceptions\CharactersExceeded (Deprecated: on twitter, now allows for multiple posts)



	```
		<?php
	
		require "vendor/autoload.php"; // If using composer
		require "dammyammy/social/autoload.php";

		$msg = isset($_REQUEST['msg']) ? $_REQUEST['msg'] : null;
		$account = isset($_REQUEST['account']) ? $_REQUEST['account'] : 'evc';

		try
		{
			// echo (new Dammyammy\Social\Twitter)->post($msg, $account);
			// echo json_encode( (new Dammyammy\Social\Twitter)->readTweets('DOsHandle', $account, 8), true);
			// echo json_encode( (new Dammyammy\Social\Twitter)->getMentions($account, 8), true);
			// echo json_encode( (new Dammyammy\Social\Twitter)->rateLimitStatus($account), true);
			echo json_encode( (new Dammyammy\Social\Twitter)->getTimeline($account), true);

		}
		catch(Dammyammy\Social\Exceptions\MessageNotSpecified $e)
		{
			echo json_encode([
				'status' => 'error', 
				'message' => 'Message Not Provided!', 
				'info' => 'Trying to Tweet without a message.'
			]);
		}
		catch(Dammyammy\Social\Exceptions\CouldNotConnect $e)
		{
			echo json_encode([
				'status' => 'error', 
				'message' => 'Request Timed Out!', 
				'info' => 'Could not make connection to twitter'
			]);
		}
		// catch(Dammyammy\Social\Exceptions\CharactersExceeded $e)
		// {
		// 	echo json_encode([
		// 		'status' => 'error', 
		// 		'message' => 'Tweet Posted is over 140 characters.', 
		// 		'info' => 'Twitter Error Code: 186'
		// 	]);;
		// }


	```


# create .env file at project root with content like this

```


# Register New Twitter Account Names [comma seperate without spaces] 

TWITTER_ACCOUNTS="john,dami"


# Twitter Account Name credentials [The account name in CAPS, '_TWITTER_', then each credentials ] 

# JOHN_TWITTER_CONSUMER_KEY="your consumer key"
# JOHN_TWITTER_CONSUMER_SECRET="your consumer secret"
# JOHN_TWITTER_ACCESS_TOKEN="your access token" 
# JOHN_TWITTER_ACCESS_SECRET="your access token secret"


# DAMI_TWITTER_CONSUMER_KEY="your consumer key"
# DAMI_TWITTER_CONSUMER_SECRET="your consumer secret"
# DAMI_TWITTER_ACCESS_TOKEN="your access token"
# DAMI_TWITTER_ACCESS_SECRET="your access token secret"



# Register New Facebook Account Names [comma seperate without spaces] 

FACEBOOK_APPS="dami"


DAMI_FACEBOOK_APP_ID="your app id"
DAMI_FACEBOOK_APP_SECRET="your app secret"
DAMI_FACEBOOK_ACCESS_TOKEN="your access token"
DAMI_FACEBOOK_PAGE_ID="your page id"
```