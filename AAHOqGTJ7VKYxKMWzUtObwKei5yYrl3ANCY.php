<?php

header('Content-Type: text/html; charset=utf-8');
require 'vendor/autoload.php';

$owner='newface';
$reserveDayNum=2;

/**
  //TEST
  $mysqli = new mysqli('localhost', 'amlakga1_jannat', 'flowercity@21', 'amlakga1_barber');
  if (!empty($mysqli->connect_errno)) {throw new \Exception($mysqli->connect_error, $mysqli->connect_errno);}

  require_once 'jdatetime/jdatetime.class.php';
  $date = new jDateTime(true, true, 'Asia/Tehran');

  $clock = $date->date("H:i", false, null, null, 'Asia/Tehran');
  $dateCall = $date->date("l Y/m/d", false, false);

  $today = mktime();
  $d = date('d', $today);
  $m = date('m', $today);
  $y = date('Y', $today);
  $tomorrow = mktime(0, 0, 0, $m, ($d + 1), $y);
  $tomorrowNext = mktime(0, 0, 0, $m, ($d + 2), $y);

  $t =$date->date("Y/m/d", $tomorrow, false, true);
  //$t="1395/06/05";
  echo $t."<br>";


  $sql="INSERT INTO `reservation`(`reserv_time`, `owner_name`, `owner_chat_id`, `reserv_fa_date`,`owner_last_name`,`year`,`month`,`day`) VALUES ('10:00','Hasan','123','$t','lastName','1','2','3')";
  echo $sql."<br>";
  $result = $mysqli->query($sql);
  print_r($result);



  exit();

 */
use Telegram\Bot\Api;

$telegram = new Api('333695757:AAHOqGTJ7VKYxKMWzUtObwKei5yYrl3ANCY');
$update = $telegram->getWebhookUpdates();

$chat_id = $update->getMessage()->getChat()->getId();
$text = $update->getMessage()->getText();
$name = $update->getMessage()->getChat()->getFirstName();
$lastName = $update->getMessage()->getChat()->getLastName();

if ($text == '/start') {

    $response = $telegram->sendMessage(['chat_id' => $chat_id, 'text' => "Welcome to Newface barbershop.\n به آرایشگاه Newface خوش آمدید."]);

    $keyboard = [['1- رزرو نوبت']];
    $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => true, 'selective' => true]);
    $response = $telegram->sendMessage(['chat_id' => $chat_id, 'text' => 'جهت رزرو دکمه زیر را فشار دهید.', 'reply_markup' => $reply_markup, 'force_reply' => true]);
}

if ($text == '/reg') {
    $response = $telegram->sendMessage(['chat_id' => 187457294, 'text' => $chat_id . "-" . $name . "-" . $lastName]);
}

$command = explode("-", $text);
if ($command[0] == '1') {
    //persian date time
    require_once 'jdatetime/jdatetime.class.php';
    $date = new jDateTime(true, true, 'Asia/Tehran');

    $clock = $date->date("H:i", false, null, null, 'Asia/Tehran');
    $dateCall = $date->date("l Y/m/d", false, false);

    $today = mktime();
    $d = date('d', $today);
    $m = date('m', $today);
    $y = date('Y', $today);
    
    for($x=1;$x<=$reserveDayNum;$x++){
        $days[]=mktime(0, 0, 0, $m, ($d + $x), $y);
    }
    
    if(count($days)==0){
        $responseStr='متاسفانه تا ';
        $responseStr.=$reserveDayNum;
        $responseStr.=" روز آینده امکان ثبت نوبت وجود ندارد";
        $response = $telegram->sendMessage(['chat_id' => $chat_id, 'text' =>$responseStr]);
    }else{
        $i=0;
        $sql="SELECT d.* FROM (";
        foreach($days as $dayi){
            $dayiStr=$date->date("Y/m/d", $dayi, false, true);
            if($i==0){
                $sql.="SELECT '$dayiStr' day ";
            }else{
                $sql.="UNION SELECT '$dayiStr'";
            }
            //$response = $telegram->sendMessage(['chat_id' => $chat_id, 'text' =>$date->date("Y/m/d", $dayi, false, true)]);
            $i++;
        }
        $sql.=") d WHERE d.day NOT IN (SELECT rd.day_fa_date FROM removed_days rd WHERE owner='newface')";
        $mysqli = new mysqli('localhost', 'amlakga1_jannat', 'flowercity@21', 'amlakga1_barber');
        if (!empty($mysqli->connect_errno)) {
            throw new \Exception($mysqli->connect_error, $mysqli->connect_errno);
        }
        $result = $mysqli->query($sql);
        $count_days = $result->num_rows;
        if($count_days>0){
            $keys = [];
            $keyborad = [];
            $str = '';
            $counter = 0;
            while ($obj = $result->fetch_object()) {
                $keys[] = '@-' ."".'-'. $obj->day;
                $counter+=1;
                if ($counter % 1 == 0) {
                    $keyboard[] = $keys;
                    $keys = [];
                }
            }
            //$keyboard=[$keys];
            $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => true, 'selective' => true]);
            $response = $telegram->sendMessage(['chat_id' => $chat_id, 'text' => 'لطفاً روز را انتخاب کنید', 'reply_markup' => $reply_markup, 'force_reply' => true]);

        }else{
            $responseStr='متاسفانه تا ';
            $responseStr.=$reserveDayNum;
            $responseStr.=" روز آینده امکان ثبت نوبت وجود ندارد"; 
        }
        $result->close();
        
        //$response = $telegram->sendMessage(['chat_id' => $chat_id, 'text' =>$sql]);
    }
    //$response = $telegram->sendMessage(['chat_id' => $chat_id, 'text' => 'لطفاً روز را انتخاب کنید', 'reply_markup' => $reply_markup, 'force_reply' => true]);;
    
    /*
    "SELECT t.* FROM 
(SELECT "Bob" name UNION SELECT "Sam" UNION SELECT "Ed") t
WHERE t.name="Ed""
    */
    /*
    $tomorrow = mktime(0, 0, 0, $m, ($d + 1), $y);
    $tomorrowNext = mktime(0, 0, 0, $m, ($d + 2), $y);

    $keyboard = [
        ["@-" . $date->date("l", $tomorrow, true, true) . "-" . $date->date("Y/m/d", $tomorrow, false, true)],
        ["@-" . $date->date("l", $tomorrowNext, true, true) . "-" . $date->date("Y/m/d", $tomorrowNext, false, true)]
    ];

    $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => true, 'selective' => true]);
    $response = $telegram->sendMessage(['chat_id' => $chat_id, 'text' => 'لطفاً روز را انتخاب کنید', 'reply_markup' => $reply_markup, 'force_reply' => true]);
    */
}

if ($command[0] == '@') {
    $days = explode("-", $text);
    $day = $days[2];
    $mysqli = new mysqli('localhost', 'amlakga1_jannat', 'flowercity@21', 'amlakga1_barber');
    if (!empty($mysqli->connect_errno)) {
        throw new \Exception($mysqli->connect_error, $mysqli->connect_errno);
    }

    $sql = "SELECT * FROM `reservation` r WHERE r.owner_chat_id='$chat_id' AND r.reserv_fa_date='$day'";
    $result = $mysqli->query($sql);
    $count_reserve = $result->num_rows;
    $result->close();

    if ($count_reserve > 0) {
        $keyboard = [["*-حذف نوبت دریافتی" . "-" . $day]];
        $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => true, 'selective' => true]);
        $response = $telegram->sendMessage(['chat_id' => $chat_id, 'text' => 'شما قبلاً نوبت ثبت کرده اید.', 'reply_markup' => $reply_markup, 'force_reply' => true]);
    } else {
        $sql = "SELECT * FROM `reservation_times` rt WHERE rt.times NOT IN (SELECT `reserv_time` FROM `reservation` WHERE `reserv_fa_date`='" . $day . "') ";
        //$response = $telegram->sendMessage(['chat_id' => $chat_id, 'text' =>$sql]);
        if ($result = $mysqli->query($sql)) {
            $count_times = $result->num_rows;
            if ($count_times == 0) {
                $response = $telegram->sendMessage(['chat_id' => $chat_id, 'text' => 'متاسفانه نوبت خالی در این روز وجود ندارد.']);
            } else {
                $keys = [];
                $keyborad = [];
                $str = '';
                $counter = 0;
                while ($obj = $result->fetch_object()) {
                    $keys[] = '#-' . $obj->times . "-" . $day;
                    $counter+=1;
                    if ($counter % 1 == 0) {
                        $keyboard[] = $keys;
                        $keys = [];
                    }
                }
                //$keyboard=[$keys];
                $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => true, 'selective' => true]);
                $response = $telegram->sendMessage(['chat_id' => $chat_id, 'text' => 'لطفاً روز را انتخاب کنید', 'reply_markup' => $reply_markup, 'force_reply' => true]);

                //$response = $telegram->sendMessage(['chat_id' => $chat_id, 'text' =>$str]);
            }


            $result->close();
        }
    }
}

if ($command[0] == '#') {
    $time1 = $command[1];
    $time2 = $command[2];
    $time = $time1 . "-" . $time2;
    $day = $command[3];

    $mysqli = new mysqli('localhost', 'amlakga1_jannat', 'flowercity@21', 'amlakga1_barber');
    if (!empty($mysqli->connect_errno)) {
        throw new \Exception($mysqli->connect_error, $mysqli->connect_errno);
    }


    $sql = "INSERT INTO `reservation`(`reserv_time`, `owner_name`, `owner_chat_id`, `reserv_fa_date`,`owner_last_name`) VALUES ('$time','$name','$chat_id','$day','$lastName')";

    if ($result = $mysqli->query($sql)) {
        //$response = $telegram->sendMessage(['chat_id' => $chat_id, 'text' => "نوبت شما با موفقیت ثبت شد."]);
        $keyboard = [["*-حذف نوبت دریافتی" . "-" . $day]];
        $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => true, 'selective' => true]);
        $response = $telegram->sendMessage(['chat_id' => $chat_id, 'text' => "نوبت شما با موفقیت ثبت شد.", 'reply_markup' => $reply_markup, 'force_reply' => true]);
    } else {
        $response = $telegram->sendMessage(['chat_id' => $chat_id, 'text' => "متاسفانه امکان ثبت وجود ندارد"]);
    } 

    $result->close();
}


if ($command[0] == '*') {
    $day = $command[2];

    $mysqli = new mysqli('localhost', 'amlakga1_jannat', 'flowercity@21', 'amlakga1_barber');
    if (!empty($mysqli->connect_errno)) {
        throw new \Exception($mysqli->connect_error, $mysqli->connect_errno);
    }
    $sql = "DELETE FROM `reservation` WHERE `reserv_fa_date`='$day' AND `owner_chat_id`=$chat_id";

    if ($result = $mysqli->query($sql)) {
        $response = $telegram->sendMessage(['chat_id' => $chat_id, 'text' => "نوبت شما با موفقیت حذف شد."]);
        $keyboard = [['1- رزرو نوبت']];
        $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => true, 'selective' => true]);
        $response = $telegram->sendMessage(['chat_id' => $chat_id, 'text' => 'جهت رزرو دکمه زیر را فشار دهید.', 'reply_markup' => $reply_markup, 'force_reply' => true]);
        $result->close();
    } else {
        $response = $telegram->sendMessage(['chat_id' => $chat_id, 'text' => "خطا در حذف!"]);
        $result->close();
    }
}

// get the list
if (strtolower($command[0]) == 'list') {
    //persian date time
    require_once 'jdatetime/jdatetime.class.php';
    $date = new jDateTime(true, true, 'Asia/Tehran');

    $dateCall = $date->date("l Y/m/d", false, false);
    
    $nextDay=0;
    if($command[1]=='1'){$nextDay=1;}
    if($command[1]=='2'){$nextDay=2;}

    $today = mktime();
    $d = date('d', $today);
    $m = date('m', $today);
    $y = date('Y', $today);
    $day = mktime(0, 0, 0, $m, ($d +$nextDay), $y);
    
    $dateStr=$date->date("Y/m/d", $day, false, true);
    
    $resoponseStr='لیست مشتریان روز ';
    $resoponseStr.=$dateStr.':';
    $response = $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $resoponseStr]);
    $resoponseStr="";
    
    $mysqli = new mysqli('localhost', 'amlakga1_jannat', 'flowercity@21', 'amlakga1_barber');
    if (!empty($mysqli->connect_errno)) {
        throw new \Exception($mysqli->connect_error, $mysqli->connect_errno);
    }
    $sql="SELECT * FROM `reservation` WHERE `reserv_fa_date`='$dateStr'";
    $result = $mysqli->query($sql);
    $count_reserve = $result->num_rows;
    //$response = $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $sql]);
    //$response = $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $count_reserve]);
    
    if($count_reserve==0){
        $resoponseStr.=' تعداد نوبت دریافتی 0 نفر است.';
        $response = $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $resoponseStr]);
    }else{
        $counter=0;
        while ($obj = $result->fetch_object()) {
            $counter+=1;
            $resoponseStr.=$counter."- ".$obj->owner_name." ".$obj->owner_last_name." "."(".$obj->reserv_time.")";
        }
        $response = $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $resoponseStr]);
    }
}

//remove days
if (strtolower($command[0]) == 'remove') {
    //persian date time
    require_once 'jdatetime/jdatetime.class.php';
    $date = new jDateTime(true, true, 'Asia/Tehran');

    $dateCall = $date->date("l Y/m/d", false, false);
    
    $nextDay=0;
    if($command[1]=='1'){$nextDay=1;}
    if($command[1]=='2'){$nextDay=2;}
    if($command[1]=='3'){$nextDay=3;}
    if($command[1]=='4'){$nextDay=4;}
    if($command[1]=='5'){$nextDay=5;}
    if($command[1]=='6'){$nextDay=6;}
    if($command[1]=='7'){$nextDay=7;}
    if($command[1]=='8'){$nextDay=8;}
    if($command[1]=='9'){$nextDay=9;}
    if($command[1]=='10'){$nextDay=10;}

    $today = mktime();
    $d = date('d', $today);
    $m = date('m', $today);
    $y = date('Y', $today);
    $day = mktime(0, 0, 0, $m, ($d +$nextDay), $y);
    
    $dateStr=$date->date("Y/m/d", $day, false, true);
    
    $mysqli = new mysqli('localhost', 'amlakga1_jannat', 'flowercity@21', 'amlakga1_barber');
    if (!empty($mysqli->connect_errno)) {
        throw new \Exception($mysqli->connect_error, $mysqli->connect_errno);
    }
    $sql="INSERT INTO `removed_days`(`owner`, `day_fa_date`) VALUES ('newface','$dateStr')";
    $result = $mysqli->query($sql);
    
    $resoponseStr='امکان رزرو در تاریخ ';
    $resoponseStr.=$dateStr;
    $resoponseStr.=' برداشته شد.';
    $response = $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $resoponseStr]);
   
}



?>
