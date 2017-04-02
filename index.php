<?php
/**
  * index.php
  *
  * @author     Ashwani Goyal <ashwanigoyal@outlook.in>
  */

 include_once 'vendor/autoload.php';

/*
Loading ENV Parameters
 */
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$tweets = new \TweetBag\AuthenticateTwitterApp();
$tweets->authenticate();
