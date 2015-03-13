<?php

require_once("../twitteroauth/src/Config.php");   
require_once("../twitteroauth/src/Response.php");   
require_once("../twitteroauth/src/SignatureMethod.php");   
require_once("../twitteroauth/src/HmacSha1.php");   
require_once("../twitteroauth/src/Consumer.php");   
require_once("../twitteroauth/src/Token.php");   
require_once("../twitteroauth/src/Util.php");   
require_once("../twitteroauth/src/Request.php");   
require_once("../twitteroauth/src/TwitterOAuth.php");

use Abraham\TwitterOAuth\TwitterOAuth;

$consumerKey = "xWHhpNgHe8O1Zunju1wVK6mpy";
$consumerSecret = "zg9KyG9S5fkXdgKtrIQ38iY1yAP8zdd0f2wH98fOWLEDRChjJr";
$accessToken = "116641865-DXCia7lrhlXh0u9i3GGiGuWz7kKd67KOpowpJJii";
$accessTokenSecret = "Ls0JZiG9R4uTRQ5qRDFcFHUwwyT7cd96lK1LlimCHWBxA";

$twObj = new TwitterOAuth($consumerKey,$consumerSecret,$accessToken,$accessTokenSecret);
$andkey = "ホワイトデー AND rakuten.co.jp";
$options = array('q'=>$andkey,'count'=>'300');

$json = $twObj->OAuthRequest(
    'https://api.twitter.com/1.1/search/tweets.json',
    'GET',
    $options
);

$jset = json_decode($json, true);
foreach ($jset['statuses'] as $result){
    $content = $result['text'];

    echo $content . '<br>';
}
?>