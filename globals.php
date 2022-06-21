<?php
require("initialize.php");


function getProfile($ID, $value = 'firstname', $type = "d"){
  global $user;
    global $conn;
    $sql = "SELECT * FROM Users WHERE USERID = '$ID'";
    $result=$conn->query($sql);
    $row = $result->fetch_assoc();

    if($value == "firstname"){
        if($ID == $user['ID']){
          if($type == "p"){
          return "Me";
        } else {
          return $row['FIRSTNAME'];
        }
        } else{

          return $row['FIRSTNAME'];
      }
    }

    if($value == "lastname"){
        return $row['LASTNAME'];
    }
    if($value == "email"){
        return $row['EMAIL'];
    }

    if($value == "username"){
        return $row['USERNAME'];
    }
    if($value == "image"){
        return $row['IMAGE'];
    }

    if($value == "number"){
      return $row['NUMBER'];
  }

  if($value == "bio"){
    return $row['BIO'];
}

  if($value == "theme"){
    return $row['THEME'];
}

    $sql = "SELECT * FROM Friends WHERE '$ID' IN (USERID, FRIENDID) AND APPROVAL = 1";
    $result=$conn->query($sql);
    if($value == "friendcount"){
        return $result->num_rows;
    }

    $sql = "SELECT * FROM Plans WHERE CREATINGUSER = $ID OR concat('-',FRIENDS,'-') LIKE '%-$ID-%'";
    $result=$conn->query($sql);

    if($value == "plancount"){
        return $result->num_rows;
    }

    $sql = "SELECT * FROM Friends WHERE FRIENDID = '$ID'  AND APPROVAL = 0";
    $result=$conn->query($sql);
    if($value == "requestcount"){
        return $result->num_rows;
    }


}

function checkFriendship ($ID1, $ID2, $mode = 'status'){


    global $conn;

    $sql = "SELECT * FROM Friends WHERE USERID = $ID1 AND FRIENDID = $ID2";
    $result=$conn->query($sql);
    if($result->num_rows === 1){
        $row = $result->fetch_assoc();
        if($row["APPROVAL"] == 1){

        if ($mode == 'status'){
        return 1;
        }

        if ($mode == 'ID'){
        return $row['ID'];
        }

        } else {
            return 2;
        }
    } else {
        $sql = "SELECT * FROM Friends WHERE USERID = $ID2 AND FRIENDID = $ID1";
        $result=$conn->query($sql);
            if($result->num_rows === 1){
                $row = $result->fetch_assoc();

            if($row["APPROVAL"] == 1){

              if ($mode == 'status'){
              return 1;
              }

            if ($mode == 'ID'){
            return $row['ID'];
            }

        } else {

              return 3;


        }


        } else {return 0;}
    }
}
function checkFriendship2 ($ID1, $ID2, $mode = 'status'){


    global $conn;

    $sql = "SELECT * FROM Friends WHERE USERID = $ID1 AND FRIENDID = $ID2";
    $result=$conn->query($sql);
    if($result->num_rows === 1){
        $row = $result->fetch_assoc();
        if($row["APPROVAL"] == 1){

          $row = $result->fetch_assoc();
    if ($mode == 'status'){
      if($row["APPROVAL"] == 1){
        return 1;

      } else {
          return 2;
        }
      }

    if ($mode == 'ID'){
      return $row['ID'];
    }

  } else {return 0;}
    } else {
        $sql = "SELECT * FROM Friends WHERE USERID = $ID2 AND FRIENDID = $ID1";
        $result=$conn->query($sql);
            if($result->num_rows === 1){
              $row = $result->fetch_assoc();
          if ($mode == 'status'){
            if($row["APPROVAL"] == 1){
              return 1;

            } else {
                return 3;
              }
            }

          if ($mode == 'ID'){
            return $row['ID'];
          }

        } else {return 0;}
    }
}

function sendMail($type, $to, $from = "1", $detail = "", $detail2 = ""){

  $mail['type'] = $type;
  $mail['to'] = $to;
  $mail['from'] = $from;
  $mail['detail'] = $detail;
  $mail['detail2'] = $detail2;

  require("mail/sendmail.php");
}

function dateFormat($date){
return date('M j', strtotime($date));

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

function getPlan($ID, $value){
  global $user;
  global $conn;
    $sql = "SELECT * FROM Plans WHERE ID = '$ID'";
    $result=$conn->query($sql);
      $row = $result->fetch_assoc();


      //Total
      $friends = explode("-", $row["FRIENDS"]);
        array_shift($friends);

        $total = count($friends);


      if($value == "name"){
        return $row["NAME"];
      }

      if($value == "creator"){
        return $row["CREATINGUSER"];
      }

      if($value == "friends"){

        return $friends;
      }

      if($value == "total"){
        return $total;
      
      }

      if($value == "replies"){
        $sql = "SELECT * FROM Plans_RSVP WHERE PLANID = '$ID'";
        $result=$conn->query($sql);
        $replied = $result->num_rows;
        return $replied;
      
      }

      if($value == "alternative_count"){
        $sql = "SELECT * FROM Plans_RSVP WHERE PLANID = '$ID' AND DATES IS NOT NULL";
        $result=$conn->query($sql);
        $replied = $result->num_rows;
        return $replied;
      
      }
      if($value == "alternative_dates"){
        $sql = "SELECT * FROM Plans_RSVP WHERE PLANID = '$ID' AND DATES IS NOT NULL";
        $result=$conn->query($sql);
        $replied = $result;
        return $replied;
      
      }

     

      if($value == "DATE1"){
        return $row["DATE1"];
      }

      if($value == "DATE2"){
        return $row["DATE2"];
      }

      if($value == "DATE3"){
        return $row["DATE3"];
      }
}