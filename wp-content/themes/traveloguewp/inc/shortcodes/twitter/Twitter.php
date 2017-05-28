<?php
# Load Twitter class
require_once('twitteroauth/twitteroauth.php');

global $polygon_redux_options;

$tw_username = $polygon_redux_options['polygon_social_tw'];
$consumer_key = $polygon_redux_options['polygon_tw_consumer_key'];
$consumer_secret = $polygon_redux_options['polygon_tw_consumer_secret'];
$access_token = $polygon_redux_options['polygon_tw_access_token'];
$access_token_secret = $polygon_redux_options['polygon_tw_access_token_secret'];

# Define constants
define('TWEET_LIMIT', 5);
define('TWITTER_USERNAME', $tw_username);
define('CONSUMER_KEY', $consumer_key);
define('CONSUMER_SECRET', $consumer_secret);
define('ACCESS_TOKEN', $access_token);
define('ACCESS_TOKEN_SECRET', $access_token_secret);

# Create the connection
$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

# Migrate over to SSL/TLS
$twitter->ssl_verifypeer = true;

# Load the Tweets
$tweets = $twitter->get('statuses/user_timeline', array('screen_name' => TWITTER_USERNAME, 'exclude_replies' => 'true', 'include_rts' => 'false', 'count' => TWEET_LIMIT));

# Example output
if(!empty($tweets)) {
    foreach($tweets as $tweet) {

        # Access as an object
        $tweetText = $tweet->text;

        # Make links active
        $tweetText = preg_replace("/(http:\/\/|(www.))(([^s<]{4,68})[^s<]*)/", '', $tweetText);

        # Linkify user mentions
        $tweetText = preg_replace("/@(w+)/", '', $tweetText);

        # Linkify tags
        $tweetText = preg_replace("/#(w+)/", '', $tweetText);

        # Output
        echo $tweetText;
        echo "<br />";

    }
}
?>