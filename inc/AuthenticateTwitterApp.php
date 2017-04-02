<?php
/**
  * Tweets
  *
  * @author     Ashwani Goyal <ashwanigoyal@outlook.in>
  */

namespace TweetBag;

use Abraham\TwitterOAuth\TwitterOAuth;
use Dotenv\Dotenv;

if(!class_exists('AuthenticateTwitterApp')){

    /**
     *  Authenticating Twitter App with APP Credentials provided in .env
     */
    class AuthenticateTwitterApp
    {

        /*
         * Twitter App Consumer Key
         */
        private $consumerKey;

        /*
         * Twitter App Consumer Secret
         */
        private $consumerSecret;

        /*
         * Twitter App Access Token
         */
        private $accessToken;

        /*
         * Twitter App Access Token Secret
         */
        private $accessTokenSecret;

        /**
         * Constructor
         *
         * Loads Twitter App Credentials and set values to class members
         */
        public function __construct()
        {
            /*
             * Loading ENV Parameters from .env
             */
            $dotenv = new Dotenv(realpath(__DIR__ . '/..'));
            $dotenv->load();

            /*
             * Setting App Values
             */
            $this->consumerKey = $_ENV['TWITTER_CONSUMER_KEY'];
            $this->consumerSecret = $_ENV['TWITTER_CONSUMER_SECRET'];
            $this->accessToken = $_ENV['TWITTER_ACCESS_TOKEN'];
            $this->accessTokenSecret = $_ENV['TWITTER_ACCESS_TOKEN_SECRET'];

        }

        /**
         * Executes the Twitter App authentication.
         * @return TwitterOAuth Twitter App Connection resource object
         */
        public function authenticate(){

            try {
                return new TwitterOAuth(
                    $this->consumerKey,
                    $this->consumerSecret,
                    $this->accessToken,
                    $this->accessTokenSecret
                );
            } catch(Exception $e) {
                echo "Execption Occured in ".__METHOD__.": ".$e->getMessage(); exit;
            }
        }
    }
}
