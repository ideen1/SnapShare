<?php
require("initialize.php");
$searchTerm = $_GET['term'];
$data = [];

if(!isset($_GET['search'])){
//get search term



    if($_GET['fill'] == "PEOPLE"){

        $result = $conn->query("SELECT * FROM Users WHERE FirstName LIKE '%".$searchTerm."%' OR LastName LIKE '%".$searchTerm."%' OR Email LIKE '%".$searchTerm."%' ORDER BY RAND() ");

        if($result->num_rows == 1){

        
            while ($row = $result->fetch_assoc()) {
                $arr['Email'] = $row["Email"];
                $arr['IMAGE'] = $row["IMAGE"];
                $arr['ID'] = $row["ID"];
                $arr['FNAME'] = $row["FirstName"];
                $arr['LNAME'] = $row["LastName"];
                $arr['Status'] = 'VALID';

                
            }

    } elseif($result->num_rows == 0){
        if (filter_var($searchTerm, FILTER_VALIDATE_EMAIL)) {
            $arr['Email'] = $searchTerm;
                $arr['IMAGE'] = "Assets/profile.png";
                //$arr['ID'] = $row["ID"];
                $arr['FNAME'] = "Send to";
                $arr['LNAME'] = "New User?";
                $arr['Status'] = 'NEW';

                
        } else{
            $arr['Email'] = "New User:";
            $arr['FNAME'] = "Type email address";
            $arr['LNAME'] = "of new user";
            $arr['Status'] = 'INVALID';
        }
    }

    $data[] = $arr;
    }

    if($_GET['fill'] == "FRIEND"){

        $result = $conn->query("SELECT * FROM Users WHERE FIRSTNAME LIKE '%".$searchTerm."%' OR LASTNAME LIKE '%".$searchTerm."%' OR USERNAME LIKE '%".$searchTerm."%' ORDER BY RAND() ");

    while ($row = $result->fetch_assoc()) {
        if(checkFriendship($user['ID'], $row["USERID"]) == 1){

        $arr['USERNAME'] = $row["USERNAME"];
        $arr['NAME'] = $row["FIRSTNAME"] . " " . $row["LASTNAME"];
        $arr['IMAGE'] = $row["IMAGE"];
        $arr['ID'] = $row["USERID"];
        $arr['FNAME'] = $row["FIRSTNAME"];
        $arr['LNAME'] = $row["LASTNAME"];

        $data[] = $arr;
      }
    }

    }

    if($_GET['fill'] == "PLANS"){

        $result = $conn->query("SELECT * FROM Plans WHERE NAME LIKE '%".$searchTerm."%' ORDER BY SID ");

    while ($row = $result->fetch_assoc()) {
        

        $arr['NAME'] = $row["NAME"];
        $arr['IMAGE'] = getProfile($row["CREATINGUSER"], 'image');

        $arr['RSVPSTATUS'] = getPlan($row['ID'], 'replies') . "/" . getPlan($row['ID'], 'total');
        $arr['ID'] = $row["ID"];

        $data[] = $arr;
      
    }

    }


} elseif($_GET['search'] == "username_validate"){

    $result = $conn->query("SELECT * FROM Users WHERE USERNAME = '$searchTerm'");
    if($result->num_rows == 1){
        $arr['STATUS'] = "ERROR";
        $arr['COLOR'] = "red";
        $arr['MESSAGE'] = "Username Unavailable. Choose Another";

    } elseif($result->num_rows == 0) {
        $arr['STATUS'] = "SUCCESS";
        $arr['COLOR'] = "green";
        $arr['MESSAGE'] = "Username Available";
    }
    $data[] = $arr;

}

    //get matched data from skills table

    echo $conn->error;


    //return json data
    echo json_encode($data);
