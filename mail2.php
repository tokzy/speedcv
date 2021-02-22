<?php
require_once "Mail.php";
$from = "isaiahtokunbo11@gmail.com";
$to = 'netsage23@gmail.com';
$host = "ssl://smtp.gmail.com";
$port = "465";
$username = 'isaiahtokunbo11@gmail.com';
$password = 'jehovah202';
$subject = "speedcv";
$body = "testing the mail package";
$headers = array ('From' => $from, 'To' => $to,'Subject' => $subject);
$smtp = Mail::factory('smtp',
 array ('host' => $host,
   'port' => $port,
   'auth' => true,
   'username' => $username,
   'password' => $password));
$mail = $smtp->send($to, $headers, $body);
if (PEAR::isError($mail)) {
 echo($mail->getMessage());
} else {
 echo("Message successfully sent!\n");
}
?>