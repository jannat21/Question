<?php
require 'vendor/autoload.php';

use Telegram\Bot\Api;

$telegram = new Api('333695757:AAHOqGTJ7VKYxKMWzUtObwKei5yYrl3ANCY');

$update = $telegram->getWebhookUpdates();

$chat_id =$update->getMessage()->getChat()->getId();
$text=$update->getMessage()->getText();
$name = $update->getMessage()->getChat()->getFirstName();
$lastName = $update->getMessage()->getChat()->getLastName();

if($text=='/start'){
	$response = $telegram->sendMessage([
  		'chat_id' =>$chat_id , 
  		'text' =>"Welcome to Newface barbershop.\n به آرایشگاه Newface خوش آمدید."
	]);
}

exit();

//persian date time
require_once 'jdatetime/jdatetime.class.php';
$date = new jDateTime(true, true, 'Asia/Tehran');

$clock=$date->date("H:i", false, null, null, 'Asia/Tehran'); 
$dateCall=$date->date("l Y/m/d", false, false);


$today = mktime();
$d = date('d', $today);
$m = date('m', $today);
$y = date('Y', $today);
   
$yesterday = mktime(0, 0, 0, $m, ($d - 1), $y);
$tomorrow = mktime(0, 0, 0, $m, ($d + 1), $y);

print_r($today);
echo "<br />\n";
echo $date->date("l Y/m/d", $today, true, true);
echo "<br />\n";
echo $date->date("l Y/m/d", $yesterday , true, true);

echo "<br />\n";
echo $date->date("l Y/m/d", $tomorrow , true, true);




$keyboard = [
    ['7', '8', '9'],
    ['4', '5', '6'],
    ['1', '2', '3'],
         ['0']
];

$reply_markup = $telegram->replyKeyboardMarkup([
	'keyboard' => $keyboard, 
	'resize_keyboard' => true, 
	'one_time_keyboard' => true,
	'selective'=>true
]);

$response = $telegram->sendMessage([
	'chat_id' => $chat_id, 
	'text' => 'سلام عدد بده!', 
	'reply_markup' => $reply_markup,
	'force_reply'=>true
]);

$messageId = $response->getMessageId();

$response = $telegram->sendMessage([
  'chat_id' =>$chat_id , 
  'text' =>"Hello ".$clock."_".$dateCall."_".$chat_id."_". $text
]);

$messageId = $response->getMessageId();



?>
