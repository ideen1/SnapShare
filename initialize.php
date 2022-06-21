<?php
session_start();
$userid = "0";
$conn = new mysqli("localhost", "root", "Think", "SnapShare");


if(isset($_COOKIE['activeSession'])){
  $sql = "SELECT * FROM Auth WHERE Token = '$_COOKIE[activeSession]'";
  $result=$conn->query($sql);
  if($result->num_rows == 1){
    $row = $result->fetch_assoc();
    
      $userid = $row['UserID'];  

  }

}


function checkLogin($id = 0){

if(isset($_COOKIE['activeSession'])){
  global $conn;

  $sql = "SELECT * FROM Auth WHERE Token = '$_COOKIE[activeSession]'";
  $result=$conn->query($sql);
  if($result->num_rows == 1){
    return true;

  } else{

    return false;
  }

} else{

    return false;
  
  
}
}



function getName($ID){
  global $conn;
  $sql = "SELECT FirstName FROM Users WHERE UserID = '$ID'";
  $result=$conn->query($sql);
  if($result->num_rows == 1){
    $row = $result->fetch_assoc();
    return $row['FirstName'];
  }

}

function lookupID($email){
  global $conn;
  $sql = "SELECT UserID FROM Users WHERE Email = '$email'";
  $result=$conn->query($sql);
  if($result->num_rows == 1){
    $row = $result->fetch_assoc();
    return $row['UserID'];
  } else {return false;}

}

function random_str(
  int $length = 64,
  string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
): string {
  if ($length < 1) {
      throw new \RangeException("Length must be a positive integer");
  }
  $pieces = [];
  $max = mb_strlen($keyspace, '8bit') - 1;
  for ($i = 0; $i < $length; ++$i) {
      $pieces []= $keyspace[random_int(0, $max)];
  }
  return implode('', $pieces);
}

function generateID($type){
  global $conn;

      

  if($type=='USER'){

    do {
      $id = random_str(10);
      $sql = "SELECT * FROM Users WHERE UserID = '$id'";
      $result = $conn->query($sql);

    }
    while($result->num_rows == 1);
    return $id;

  }

  if($type=='TOKEN'){

    do {
      $id = random_str(100);
      $sql = "SELECT * FROM Users WHERE UserID = '$id'";
      $result = $conn->query($sql);

    }
    while($result->num_rows == 1);
    return $id;

  }


  if($type=='IMAGE'){

    do {
      $id = random_str(30);
      $sql = "SELECT * FROM Images WHERE ImageID = '$id'";
      $result = $conn->query($sql);

    }
    while($result->num_rows == 1);
    return $id;

  }

  if($type=='EVENT'){
    do {
      $id = random_str(50);
      $sql = "SELECT * FROM Events WHERE EventID = '$id'";
      $result= $conn->query($sql);

    }
    while($result->num_rows == 1);
    return $id;
  }

}

/*
if(isset($_SESSION['ID'])){
    $user['ID'] = $_SESSION['ID'];
}

if(isset($_COOKIE['linkupAuth'])){
  $sql = "SELECT * FROM Sessions WHERE TOKEN = '$_COOKIE[linkupAuth]' AND ACTIVE = 1";
    $result1=$conn->query($sql);
    $row = $result1->fetch_assoc();

    $user['ID'] = $row['USERID'];
    
}

if($user['ID'] == 7){
//Display Errors if it's Ideen

} else{
  error_reporting(0);
}

//BLOCK
if($user['ID'] == 60 || $user['ID'] == 59 || $user['ID'] == 52){
    die("Unexpected Error Encountered: <b>ES51.1</b>");
}


$sql = "SELECT * FROM Users WHERE USERID = '$user[ID]'";

$result=$conn->query($sql);
$row = $result->fetch_assoc();

$user['USERNAME'] = $row['USERNAME'];
$user['theme'] = $row['THEME'];

$user['INTER_APP'] = $row['INTER_APP'];
$user['INTER_NUMBER'] = $row['INTER_NUMBER'];

if(!isset($_SESSION['ID']) && $result1->num_rows == 0){
    header("Location: redirect.php?url=index.php");
}
*/