<?php
class SMS{

  public static $sender='ALPHA_SENDER';
  public static $login='LOGIN';
  public static $pwd='PASSWORD';    
  /**
   *  $r - Recipient
   *  $m - Message
   *  $d - Date, default "NOW()"
   */     
  public static function send($r,$m,$d=false){
    try{
    	$pdo = new PDO ("mysql:host=77.120.116.10;dbname=users",SMS::$login,SMS::$pwd);
    	$pdo->query("SET NAMES utf8;");
	    if($d==false)
	      $pdo->query("INSERT INTO `{SMS::$login}` (`number`,`message`,`sign`) VALUES ('$r','$m','chili')");
	    else
	      $pdo->query("INSERT INTO `{SMS::$login}` (`number`,`message`,`sign`,`send_time`) VALUES ('$r','$m','{SMS::$sender}','$d')");
    }catch(Exception $e){
			$client = new SoapClient ('http://turbosms.in.ua/api/wsdl.html'); 
			$auth = array( 
				'login' => $login, 
		        'password' => $pwd 
        	); 
        	$res=$client->Auth($auth);
        	$sms = array( 
        		'sender' => $sender, 
        		'destination' => $r, 
		        'text' => $m
        	);
        	$res=$client->SendSMS($sms); 
    }
  }
}

