<?php

$conn = new mysqli("localhost", "root", "Think", "SnapShare");

if(!isset($_GET['token'])){
    
} else{
    $sql = "UPDATE InvitationToken SET EmailRead = 1 WHERE Token = '$_GET[token]'";
    $result= $conn->query($sql);
}
$name = './Assets/Logo.png';

$fp = fopen($name, 'rb');

// send the right headers
header("Content-Type: image/png");
header("Content-Length: " . filesize($name));

// dump the picture and stop the script
fpassthru($fp);
exit;