<?php
// http://www.acornartwork.com/blog/2010/04/12/tutorial-twitter-rss-feed-parser-in-pure-php/
// Ann Christin Kern
// Modified by Charles R. Portwood II for Yii Class

class JTwitterParser {
	
	public $username;
	public $maxtweets;
	public $apiKey;
	public $apiSecretKey;
	
	public function fetch_tweets($username, $maxtweets) {
		 //Using simplexml to load URL
		 $tweets = simplexml_load_file("http://twitter.com/statuses/user_timeline/" . $username . ".rss");

		 $tweet_array = array();  //Initialize empty array to store tweets
		 foreach ( $tweets->channel->item as $tweet ) { 
			  //Loop to limitate nr of tweets.
			  if ($maxtweets == 0) {
				   break;
			  } else {
				   $twit = $tweet->description;  //Fetch the tweet itself

				   //Remove the preceding 'username: '
				   $twit = substr(strstr($twit, ': '), 2, strlen($twit));

				   // Convert URLs into hyperlinks
				   $twit = preg_replace("/(http:\/\/)(.*?)\/([\w\.\/\&\=\?\-\,\:\;\#\_\~\%\+]*)/", "<a href=\"\\0\">\\0</a>", $twit);

				   // Convert usernames (@) into links 
				   $twit = preg_replace("(@([a-zA-Z0-9\_]+))", "<a href=\"http://www.twitter.com/\\1\">\\0</a>", $twit);

				   // Convert hash tags (#) to links 
				   $twit = preg_replace('/(^|\s)#(\w+)/', '\1<a href="http://search.twitter.com/search?q=%23\2">#\2</a>', $twit);

				   //Specifically for non-English tweets, converts UTF-8 into ISO-8859-1
				   $twit = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $twit);

				   //Get the date it was posted
				   $pubdate = strtotime($tweet->pubDate); 
				   $propertime = gmdate('F jS Y, H:i', $pubdate);  //Customize this to your liking

				   //Store tweet and time into the array
				   $tweet_item = array(
						 'desc' => $twit,
						 'date' => $propertime,
				   );
				   array_push($tweet_array, $tweet_item);

				   $maxtweets--;
			  }
		 }
		 //Return array
		 return $tweet_array;
		 }
	}
?>