<?php
/**
  * tweets.php
  *
  * @author     Ashwani Goyal <ashwanigoyal@outlook.in>
  */

/**
 * Check if this endpoint is called securely
 */
if(!isset($_GET['auth_token']) || $_GET['auth_token'] != md5('tweet-bucket-tweets')){
    header("HTTP/1.1 401 Unauthorized");
    exit('Not Authorized Call!');
}

include_once '../vendor/autoload.php';

use \TweetBag\Tweets;

$tweetsObject = new Tweets();

/**
 * Get the Tweets Array
 */
$tweets = $tweetsObject->fetchTweets();

/**
 * Empty Object to carry the output
 */
$result = new stdClass();

/* Are we getting tweets or not? */
if (!empty($tweets) && !empty($tweets->statuses)) {

    /* I will count the tweets being displayed */
    $tweetCount = 1;
    $result->data = array();

    /* I will loop through the tweets in hand */
    foreach ($tweets->statuses as $tweet) {

        /* Is this tweet have more than 0 retweet? */
        if ($tweet->retweet_count > 0) {

            $result->data[] = array(
                'tweetCount' => $tweetCount,
                'tweetText' => $tweet->text,
                'retweetCount' => $tweet->retweet_count,
                'createdAtNiceTimeStamp' => $tweetsObject->niceTimeStamp($tweet->created_at),
                'profileImageUrl' => $tweet->user->profile_image_url,
                'userName' => $tweet->user->name,
                'userScreenName' => $tweet->user->screen_name
            );

            $result->status = true;
            $result->message = "Matching tweets were found";

            $tweetCount++;

        }
    }
    header("HTTP/1.1 200 OK");
} else {

    // No Content was found
    header("HTTP/1.1 204 No Content");
}

echo json_encode($result); exit;
?>
