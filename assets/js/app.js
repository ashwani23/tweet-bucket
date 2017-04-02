jQuery(document).ready(function(){
    jQuery.ajax({
        method : 'GET',
        url : 'api/tweets.php',
        dataType : "json",
        data : {'auth_token' : '82a27432347dc1ba414bf7219d729ea1'},
        success : function(response){
            var htmlString = '';
            if(typeof response != 'undefined'){
                jQuery.each(response.data, function(tweetIndex, tweet){
                    htmlString += '<div class="col-md-6 tweet"><div class="testimonials"> <div class="active item"><blockquote><p><span class="badge">'+tweet.tweetCount+'</span>&nbsp;'+tweet.tweetText+'</p><p><span class="label label-success">Retweet(s): '+tweet.retweetCount+'</span><span class="label label-warning">'+tweet.createdAtNiceTimeStamp+'</span></p></blockquote><div class="carousel-info"><img alt="" src="'+tweet.profileImageUrl+'" class="pull-left"><div class="pull-left"><span class="testimonials-name">'+tweet.userName+'</span><span class="label label-primary"># '+tweet.userScreenName+'</span></div></div></div></div></div></div>';
                });
            } else {
                htmlString = '<div class="alert alert-danger">No matching tweet was found</div>';
            }
            jQuery('#tweets').html(htmlString);
        }
    });
});
