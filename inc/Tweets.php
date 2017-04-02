<?php
/**
  * Tweets.php
  *
  * @author     Ashwani Goyal <ashwanigoyal@outlook.in>
  */

/*
 * TweetBag Utility Package for App
 */
namespace TweetBag;

use Dotenv\Dotenv;

if(!class_exists('Tweets')){

    /**
     * Tweets
     *
     * Fetch the Tweets
     * @package TweetBag
     */
    class Tweets
    {

        /**
         * Object to interact with Twitter API
         *
         * @var \Abraham\TwitterOAuth\TwitterOAuth
         */
        private $twitterOAuth;

        /**
         * Contains the hashtag
         *
         * @var string $hashtag
         */
        private $hashTag;

        /**
         * Relative path of the API
         *
         * @var string
         */
        private $twitterPath;

        /**
         * Max number of records to be fetched from Twitter at a time
         *
         * @var int $count default value is 100
         */
        private $fetchCount;

        /**
         * Constructor
         */
        public function __construct()
        {
            $authenticateTwitterAppClass = new AuthenticateTwitterApp();
            $this->twitterOAuth = $authenticateTwitterAppClass->authenticate();

            /*
             * Loading ENV Parameters from .env
             */
            $dotenv = new Dotenv(realpath(__DIR__ . '/..'));
            $dotenv->load();

            /*
             * Setting Search parameter/configuration
             */
            $this->hashTag = $_ENV['TARGET_HASHTAG'];
            $this->twitterPath = $_ENV['TWITTER_SEARCH_TWEETS_ENDPOINT'];
            $this->fetchCount = $_ENV['TWEETS_TO_SHOW'];
        }

        /**
         * To fetch tweets from Twitter API
         *
         * @return array All the matching Tweets (based upon search parameters)
         */
        public function fetchTweets()
        {
            try{
                $result = array();

                $result = $this->twitterOAuth->get(
                    $this->twitterPath,
                    array(
                        'q' => $this->hashTag,
                        'count' => $this->fetchCount
                    )
                );

                return $result;
            } catch(Exception $e){

                /*
                 * Exit from App if Authentication Fails while writing a message
                 */
                echo "Execption Occured in ".__METHOD__.": ".$e->getMessage().". You are requested to reach us at admin@example.com.";
            }
        }


        /**
         * Generates a nice time stamp
         * @param  string  $a Tweet's Timestamp
         * @return string  Nice Timestamp String
         */
    	public function niceTimeStamp($a) {
    		# get current timestampt
    		$b = strtotime("now");

    		# get timestamp when tweet created
    		$c = strtotime($a);

    		# get difference
    		$d = $b - $c;

    		# calculate different time values
    		$minute = 60;
    		$hour = $minute * 60;
    		$day = $hour * 24;
    		$week = $day * 7;

    		if(is_numeric($d) && $d > 0) {
    			# if less then 3 seconds
    			if($d < 3) return "right now";

    			# if less then minute
    			if($d < $minute) return floor($d) . " seconds ago";

    			# if less then 2 minutes
    			if($d < $minute * 2) return "about 1 minute ago";

    			# if less then hour
    			if($d < $hour) return floor($d / $minute) . " minutes ago";

    			# if less then 2 hours
    			if($d < $hour * 2) return "about 1 hour ago";

    			# if less then day
    			if($d < $day) return floor($d / $hour) . " hours ago";

    			# if more then day, but less then 2 days
    			if($d > $day && $d < $day * 2) return "yesterday";

    			# if less then year
    			if($d < $day * 365) return floor($d / $day) . " days ago";

    			# else return more than a year
    			return "over a year ago";
    		}
    	}
    }


}
