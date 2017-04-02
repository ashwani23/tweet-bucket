<?php include_once 'vendor/autoload.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Tweet Bucket</title>
    <meta name="generator" content="Bootply" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
      <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
      <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css" >
      <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="./css/style.css" >
  </head>
  <body>
      <div class="container content">
          <h2>Tweet Bucket</h2>
          <p>Small Application that fetches tweets with hashtag <b>#custserv</b> and those are retweeted atleast once</p>
          <br/>
          <?php
			$tweets = (new \TweetBag\Tweets())->fetchTweets();

          # Are we getting tweets or not?
          if (!empty($tweets) && !empty($tweets->statuses)) {

              # I will count the tweets being displayed
              $tweetCount = 1;

              # I will loop through the tweets in hand
              foreach ($tweets->statuses as $tweet) {

                  # Is this tweet have more than 0 retweet?
                  if ($tweet->retweet_count > 0) {
                      ?>
                      <div class="col-md-6 tweet">
                          <div class="testimonials">
                              <div class="active item">
                                  <blockquote>
                                      <p><span class="badge"><?php echo $tweetCount; ?></span>&nbsp;<?php echo $tweet->text; ?></p>
                                      <p>
                                          <span class="label label-success">Retweet(s): <?php echo $tweet->retweet_count; ?></span>
                                          <span class="label label-warning"><?php echo (new \TweetBag\Tweets())->niceTimeStamp($tweet->created_at); ?></span>
                                      </p>
                                  </blockquote>
                                  <div class="carousel-info">
                                      <img alt="" src="<?php echo $tweet->user->profile_image_url; ?>" class="pull-left">
                                      <div class="pull-left">
                                          <span class="testimonials-name"><?php echo $tweet->user->name; ?></span>
                                          <span class="label label-primary"># <?php echo $tweet->user->screen_name; ?></span>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <?php
                      $tweetCount++;
                  }
              }
          } else {
              echo '<div class="alert alert-danger" role="alert">No matching Tweets were found</div>';
          }
          ?>

      </div>
  </body>
</html>
