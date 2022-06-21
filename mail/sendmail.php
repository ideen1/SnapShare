<?php

//Vars to input in email
$templatefill['smallmessage'];
$templatefill['top_title'];
$templatefill['sub_title'];
$templatefill['bold_message'];
$templatefill['message'];
$templatefill['buttonurl'];
$templatefill['buttontext'];

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
$headers .= "From: SnapShare<312nas@gmail.com>" . "\r\n" .
"Reply-To: snapshare@ideen.ca" . "\r\n" .
"X-Mailer: PHP/" . phpversion();


if($mail['type']== "invite"){
  $templatefill['smallmessage'];
  $templatefill['top_title'] = "$mail[creator] has sent you pictures from $mail[event]!<br>";
  $templatefill['sub_title'] = "Share all the picture you took at $mail[event] so everyone can see them in <i>one</i> secure place!";
  $templatefill['bold_message'] = "<br>View and upload your own pictures now!";
  $templatefill['message'] = "<b>What is SnapShare?: </b> SnapShare is a secure platform for sharing pictures from events so that everyone who was there can get them! No more spamming the groupchat!";
  $templatefill['buttonurl'] = "https://312.ideen.ca/apps/SnapShare?invite=$mail[token]";
  $templatefill['buttontext'] = "Go to Event Pictures Page";
  $subject = "Pictures for $mail[event] from $mail[creator]";
  
}

require("templates/main/email.php");

$to = $mail['email'];


$message = $template;

mail($to, $subject, $message, $headers);
