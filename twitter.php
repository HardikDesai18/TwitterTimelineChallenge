<?php 

 include_once('libs/TwitterAPIExchange.php');
 
 $twitter_consumer_key = '8yM23w2h2ztc4tTzlRaBzbIbl'; 
     
 $twitter_consumer_secret = 'ec55lCy8aAWxIbHfijLVbp8Ord5E7NhXD3pLGExsXtMmIRiydb';   
 
 $twitter_access_token = '753102090-R1x29O155V40IR29mtfGM3xw7wf5snweRLdfGGPv'; 
 
 $twitter_access_token_secret = '6oGUlstLxKJ5gxnmKd1YgFuvLQk5S5QKl9EkpGVubMaou'; 
  
 $twitter_id = 'hardikdesaii'; 
     
 $twitter_count = '10'; 
 
 //$twitter_cp_count = theme_get_setting('twitter_baincp_no_tweet'); 

 if($twitter_id && $twitter_consumer_key && $twitter_consumer_secret && $twitter_access_token && $twitter_access_token_secret && $twitter_count) {
     $settings = array(
    'oauth_access_token' => $twitter_access_token,
    'oauth_access_token_secret' => $twitter_access_token_secret,
    'consumer_key' => $twitter_consumer_key,
    'consumer_secret' => $twitter_consumer_secret
    );
    		 	
	$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';

		$getfield = '?username='.$twitter_id.'&count='.$twitter_count;
		
	
	//if(strtolower($node->field_module['und']['0']['value']) == 'community partnership') {
		/*$url = "https://api.twitter.com/1.1/search/tweets.json";
		$getfield ='?q=%23BaincapitalCP&count='.$twitter_count;*/
	//} else {
		/*$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
		$getfield = '?username='.$twitter_id.'&count='.$twitter_count;*/
	//}
	//echo $url.$getfield;die;
	$requestMethod = 'GET';
    $twitter = new TwitterAPIExchange($settings);
    
    $tweets = $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();  
    
    $tweets_arr = json_decode($tweets);
	$customtweet_array = array();
	$alltweet_array = array();
	$tweetarray	= array();

		/*$i = 1;
		$theme_val = $twitter_count;*/
	//echo "<pre>";
	//print_r($tweets_arr);
	//die;
	foreach($tweets_arr as $each_tweets){
						
				$pos = strpos($each_tweets->text, 'https://'); 
				$tweet_text = substr($each_tweets->text, 0, $pos); 
				$tweet_url = substr($each_tweets->text, $pos); 
				
				$redirect_url = (!empty($each_tweets->entities->urls[0]->url)?$each_tweets->entities->urls[0]->url:'');
				$tweetarray['date'] = date("m/d/y", strtotime($each_tweets->created_at));
				$tweetarray['tweet_text'] = $each_tweets->text;
				$tweetarray['redirect_url'] = $redirect_url;
				$tweetarray['tweet_url']	=	$tweet_url;
				
				array_push($alltweet_array,$tweetarray);
		}
		$tweets_arr = $alltweet_array;
} 
?>
 
<html>

<!-- script-->
<script src="assets/js/jquery-3.1.0.js"></script>
<script src="assets/js/owl.carousel.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/custom.js"></script>
<!--css-->
<link rel="stylesheet" href="assets/css/owl.carousel.css" />
<link rel="stylesheet" href="assets/css/owl.theme.css" />
<link rel="stylesheet" href="assets/css/owl.transitions.css" />
<link rel="stylesheet" href="assets/css/style.css" />
<body>
<!--<div id="owl-demo" class="owl-carousel owl-theme" style="height:30%;width:30%;">
 
  <div class="item"><img  src="assets/img/1.png" alt="1"></div>
  <div class="item"><img  src="assets/img/2.png" alt="2"></div>
  <div class="item"><img src="assets/img/3.png" alt="3"></div>
 
</div>-->

<div id="owl-demo" class="owl-carousel owl-theme" style="height:30%;width:30%;background:#0047bb;">
	<?php
		$size=sizeof($tweets_arr);
		
		foreach ($tweets_arr as $value)
		{
		?>
			<div class="item" >
			<li class="item" >
				<span style="color:white;"><?php echo $value['date'] ?></span>
				<p  style="color:white;"><?php echo $value['tweet_text'] ?></p>
			</li>
			</div>
<?php 
		}
	?>
	</div>
  


</body>

</html> 