<?php
// stop errors and warnings and setup as json response
error_reporting(0);
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$mode = "HTML"; // HTML || Markdown

// use Telegram api to send data
function SendTG($user, $msg, $token){
  $url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$user&text=$msg&parse_mode=$mode";
  return file_get_contents($url);
}

// receive data from request 
if (isset($_GET["user"]) && isset($_GET["message"])) {
  if (isset($_GET["token"])) {
    $token = $_GET["token"];
  } else {
    // put your default bot token here :
    $token = "12345xxxxx:ABCxxxxxxxxxxxxxxxxx-abcxxxxxxxxx";
  }
  $req = SendTG($_GET["user"], $_GET["message"], $token);
  if (json_decode($req)) {
    echo str_replace("  ", " ", json_encode(json_decode($req), 128));
  } else {
    echo str_replace("  ", " ", json_encode([
      "ok"=> false,
      "result"=> $req
    ], 128));
  }
} else {
  echo str_replace("  ", " ", json_encode([
    "ok"=> false,
    "result"=>"user id and message are required !"
  ], 128));
}