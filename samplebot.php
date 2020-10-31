<?php

require_once("class.php");
require_once("functions.php");

$botObject = new SampleBotClass();

$updates = file_get_contents("php://input");
$update_array = json_decode($updates, TRUE);

$botObject->FillValues($update_array);

$text = strip_tags(trim($botObject->GetMessageText()));

// get username
$username = $botObject->GetUsername();

// check received message type
$message_type = $botObject->GetMessageType();

// get phone number
$phone_number = $botObject->GetPhoneNumber();

if($text == "/help")
{
	// do something...
	$botObject->SendMessage("This is the first message you received from the bot.");
}
else
{
	$botObject->SendMessage("online support. Tel: +XX.XXXXXXX");
}

//$botObject->SendMessage($message_type);
//$botObject->SendMessage($phone_number);
//$botObject->SendMessage($updates);

?>