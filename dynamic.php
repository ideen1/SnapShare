<?php
require('initialize.php');


if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest'){

} else{
    die("Invalid Request Error: <b>The Request to the secure API Backend attempted outside of application runtime has been blocked - Error #SE1</b>");
}

if(checkLogin()){
    
   
} elseif($_POST['page'] === 'login' || $_POST['page'] === 'signup' || $_POST['page'] === 'invite' || $_POST['page'] == "eventName"){
    
} else{
    echo "<script>pageLogin();</script>";
    die();
}



switch ($_POST['page']){
    //CASE FOR EVENTS

    case "events":
        echo "<div class='small_body centered'>";

        /*

        $sql = "SELECT * FROM Events WHERE (CreatingID = 1 OR concat('-',SharedID,'-') LIKE '%-$user[ID]-%')";
        $result=$conn->query($sql);
        echo "New invites:";

        while ($row=$result->fetch_assoc()){
            echo "<div class='event_item_box'>";
            echo "<p class='event_item_title'>" . $row['Name'] . "</p>";
            echo "<span class='event_item_buttons'><button><img src='Assets/check.png'>Accept</button><button><img src='Assets/warning.png'>Reject</button></span>";
            echo "</div>";
        }

        echo "<br><hr><br>";

        */

        
        //echo "<div class='' style='position:relative; border:0px; '>";
        echo "<button onclick='pageUpload();' style='position:relative;float:right; top:-50px;'>New Event</button><br><br>";
        //echo "</div>";


    
        $sql = "SELECT * FROM Events WHERE (CreatingID = '$userid' OR concat('-',SharedID,'-') LIKE '%-$userid-%')";
        $result=$conn->query($sql);
        //echo "Your events:";

        while ($row=$result->fetch_assoc()){
            echo "<div class='event_item_box'>";
            echo "<p class='event_item_title'>" . $row['Name'] . "</p>";
            echo "<span class='event_item_buttons'><!--<button><img src='Assets/edit.png'>Edit</button>--><button onclick=pageEvent('$row[EventID]')><img src='Assets/view.png'>View</button><button onclick=pageEventFwdUpload('$row[EventID]'); ><img src='Assets/upload.png'>Upload</button></span>";
            echo "</div>";
        }


        echo "</div>";

    break;

    case 'login':

        if(isset($_POST['invite'])){
            
            $disabled = "readonly";
            $sql = "SELECT * FROM InvitationToken WHERE Token = '$_POST[invite]'";
            $result= $conn->query($sql);
            if($result->num_rows == 1){

                $row = $result->fetch_assoc();
                $emailmes = "<p>Simply login to view all images!</p>";
                $_POST['fwd'] = "index.php?spt=event&sptid=$row[EventID]&alert=LoggedEdit" ;
            }
        }

        echo "<div class='centered'>";
        echo "<form method='POST' action='action.php?command=login'>
                
                <input $disabled type='text' name='email' value='$row[Email]' placeholder='Email'><br>
                $emailmes
                <input type='password' name='password' placeholder='Password'><br>
                <input type='hidden' name='forward' value='$_POST[fwd]'>
                <input type='hidden' name='token' value='$_POST[invite]'>
                <input type='submit' value='Login'>
        </form>";
        echo "</div>";
    break;




    case 'signup':

        if(isset($_POST['invite'])){
            
            $disabled = "readonly";
            $sql = "SELECT * FROM InvitationToken WHERE Token = '$_POST[invite]'";
            $result= $conn->query($sql);
            if($result->num_rows == 1){

                $row = $result->fetch_assoc();
                $emailmes = "<p>Simply Set a Name and Password to view all images</p>";
                $_POST['fwd'] = "index.php?spt=event&sptid=$row[EventID]&alert=LoggedEdit" ;
            }
        }

        echo "<div class='centered'>";
        echo "<form method='POST' action='action.php?command=signup'>
                <input  type='text' name='email' placeholder='Email' value='$row[Email]' $disabled><br>
                $emailmes
                <input type='text' name='name' placeholder='Name'><br>
                <input type='password' name='password' placeholder='Password'><br>
                <input type='hidden' name='forward' value='$_POST[fwd]'>
                <input type='hidden' name='token' value='$_POST[invite]'>
                <input type='submit' value='Sign Up'>
        </form>";
        echo "</div>";
    break;


    //CASE FOR CREATING NEW EVENT
    case "new":
        
        echo "<form style='width:100%; max-width:600px;' class='centered' action='action.php?command=new' id='newForm'  method='post'>
        <input placeholder='Name' autofocus name='name' onchange=$('#body_title').html(this.value);><br><br>
        <input id='people' type='text' placeholder='Email or Name' />

        <input id='people_id' name='people' type='hidden' required value = '' /><br><br>

        <div id='invitees'>
        </div><br><br>
        <input type='submit' onclick='loaderShow();'>
        <form/>

        <script src='makeplan.js'></script>
        ";
        


    break;

    $sql = "SELECT * FROM InvitationToken WHERE Token = '$_GET[invite]'";
    $result= $conn->query($sql);
    if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        
    }


 
 case "invite":
    //CASE FOR VIEWING AN Invite

    if(isset($_POST['ID'])){

        $sql = "INSERT INTO AccessLog (TOKEN, USERAGENT) VALUES('$_POST[ID]', '$_SERVER[HTTP_USER_AGENT]')";
        $result= $conn->query($sql);

        $sql = "SELECT * FROM InvitationToken WHERE Token = '$_POST[ID]'";
        $result= $conn->query($sql);
        if($result->num_rows == 1){

            $row = $result->fetch_assoc();
            

            if(checkLogin()){
                echo "<script>pageEvent('$row[EventID]');</script>";
                die();
            }
        
        $sql = "SELECT * FROM Events WHERE EventID = '$row[EventID]' AND concat('-',SharedID,'-') LIKE '%-$row[UserID]-%'";
        
        $result=$conn->query($sql);
        

        if($result->num_rows == 1){
            $row=$result->fetch_assoc();

            

            echo "<script>var EventID = '$row[EventID]';</script><script src='Assets/dropzone.js'></script>";
          
            $creatorName = getName($row['CreatingID']);
            echo "<h1 >$row[Name] </h1>";
            echo "<h4 '>Shared By $creatorName</h4>";
            echo "<span class='event_item_buttons' style='width:100%; max-width:500px; position:relative; margin:10px auto; padding:5px; float:left;'>
            <button  style='opacity:0.2; border:1px solid black; margin:5px; border-radius:4px;' onclick=\"alert('Login first to upload/download and view all images!')\";><img src='Assets/upload.png'>Upload your own pictures</button>
            <button  style='opacity:0.2; border:1px solid black; margin:5px; border-radius:4px;' onclick=\"alert('Login first to upload/download and view all images!')\";><img src='Assets/download.png'>Download All</button>
            </span><br><br><br><br><br><br>";
           // echo "<div class='event_item_box' style='position:relative; background:rgba(0,0,0,0);' mar-top:70px;>";
            

                $sql = "SELECT * FROM Images WHERE EventID = '$row[EventID]' LIMIT 5";
                $result=$conn->query($sql);
                $total = $result->num_rows;
                
                
                if($result->num_rows >= 1){
                    
                    $i = 1;
                    $rows = [];

                    while ($row = $result->fetch_assoc()){
                        $rows[$row['ImageID']]["ID"] = $row['ImageID'];
                        $rows[$row['ImageID']]["Index"] = $i;
                        $rows[$row['ImageID']]["URL"] = $row['URL'];
                        $rows[$row['ImageID']]["ALT"] = $row['ALT'];
                        $rows[$row['ImageID']]["ThumbURL"] = $row['ThumbURL'];
                        $rows[$row['ImageID']]["ThumbURL"] = $row['URL'];
                        $i++;

                    }
                    

                    echo "<div class='images_box'>";

                        echo "<div class='grid' ><div class='grid-sizer'></div>You will need to login or signup to view all pictures";
                        foreach($rows as $item){
                            //LOOP FOR MAIN IMAGES
                            echo "<div class='grid-item'>";
                            //echo "<img class='hover-shadow' src='$item[URL]' onclick='openModal();currentSlide($item[Index])'>";
                            echo "<a href='$item[URL]' data-lightbox='viewerset' data-title='$item[ALT]'><img class='hover-shadow' src='$item[ThumbURL]'></a>";
                            echo "</div>";

                        }
                 
                        echo "</div>";
                        echo "</div>";

        
                
                }


            echo "</div>";

            echo "<script src='event.js'></script>";

           

           

        } else {echo "<script>popNotification('The email link you have clicked has expired. Login or Sign Up to view Events available to you or create your own!', 'Purple');</script>";}

            
    }
    }
    break; 


    //CASE FOR VIEWING AN EVENT
    case "event":
    if(isset($_POST['ID'])){

        
        $sql = "SELECT * FROM Events WHERE EventID = '$_POST[ID]' AND (CreatingID = '$userid' OR concat('-',SharedID,'-') LIKE '%-$userid-%')";
        
        $result=$conn->query($sql);

        if($result->num_rows == 1){
            $row=$result->fetch_assoc();

            

            echo "<script>var EventID = '$row[EventID]';</script><script src='Assets/dropzone.js'></script>";
          
            $creatorName = getName($row['CreatingID']);
            echo "<h4 style='float:left;'>Shared By $creatorName</h4><br>";
            echo "<span class='event_item_buttons' style='width:100%; max-width:500px; position:relative; margin:10px auto; padding:5px; float:left;'>
            <button style='border:1px solid black; margin:5px; border-radius:4px;' id='upload_button' ><img src='Assets/upload.png'>Upload your own pictures</button>
            <button style='border:1px solid black; margin:5px; border-radius:4px;'onclick=download('$row[EventID]')><img src='Assets/download.png'>Download All</button>
            </span><br><br><br><br><br><br>";
           // echo "<div class='event_item_box' style='position:relative; background:rgba(0,0,0,0);' mar-top:70px;>";
            

                $sql = "SELECT * FROM Images WHERE EventID = '$_POST[ID]' $limitsql";
                $result=$conn->query($sql);
                $total = $result->num_rows;
                
                
                if($result->num_rows >= 1){
                    
                    $i = 1;
                    $rows = [];

                    while ($row = $result->fetch_assoc()){
                        $rows[$row['ImageID']]["ID"] = $row['ImageID'];
                        $rows[$row['ImageID']]["Index"] = $i;
                        $rows[$row['ImageID']]["URL"] = $row['URL'];
                        $rows[$row['ImageID']]["ALT"] = $row['ALT'];
                        $rows[$row['ImageID']]["ThumbURL"] = $row['ThumbURL'];
                        //$rows[$row['ImageID']]["ThumbURL"] = $row['URL'];
                        $i++;

                    }
                    
                    /*
                    echo "<div class='images_box'>";

                        echo "<div class='row'>";
                        foreach($rows as $item){
                            //LOOP FOR MAIN IMAGES
                            echo "<div class='column'>";
                            //echo "<img class='hover-shadow' src='$item[URL]' onclick='openModal();currentSlide($item[Index])'>";
                            echo "<a href='$item[URL]' data-lightbox='viewerset' data-title='$item[ALT]'><img class='hover-shadow' src='$item[URL]'></a>";
                            echo "</div>";

                        }
                 
                        echo "</div>";
                        echo "</div>";
                        */

                        echo "<div class='images_box'>";

                        echo "<div class='grid' ><div class='grid-sizer'></div>";
                        foreach($rows as $item){
                            //LOOP FOR MAIN IMAGES
                            echo "<div class='grid-item'>";
                            //echo "<img class='hover-shadow' src='$item[URL]' onclick='openModal();currentSlide($item[Index])'>";
                            echo "<a href='$item[URL]' data-lightbox='viewerset' data-title='$item[ALT]'><img class='hover-shadow' src='$item[ThumbURL]'></a>";
                            echo "</div>";

                        }
                 
                        echo "</div>";
                        echo "</div>";

        


/*
                        echo "<div id='myModal' class='modal'>";
                        echo "<span class='close cursor' onclick='closeModal();'>&times;</span>";
                        echo "<div class='modal-content'>";
                        $i=1;
                        foreach($rows as $item){
                            //LOOP FOR MODAL LIGHTBOX
                            echo "<div class='mySlides'>";
                            echo "<div class='numbertext'>$item[Index] / $total</div>";
                            echo "<img src='$item[URL]' style='width:100%;' alt='$row[ALT]'>";
                            echo "</div>";
                            $i++;

                        }

                        echo "<!-- Next/previous controls -->
                        <a class='prev' onclick='plusSlides(-1)'>&#10094;</a>
                        <a class='next' onclick='plusSlides(1)'>&#10095;</a>";

                        echo "<!-- Caption text -->
                        <div class='caption-container'>
                          <p id='caption'></p>
                        </div>";


                        foreach($rows as $item){
                            //LOOP FOR THUMBNAILS
                            echo "<div class='column'>";
                            echo "<img class='demo' src='$item[URL]' onclick='openModal();currentSlide($item[Index])' alt='$item[ALT]'>";
                            echo "</div>";


                        }


                        echo "</div>";
                        echo "</div>";

*/





                    
        
                
                }


            echo "</div>";

            echo "<script src='event.js'></script>";

            if (isset($_GET['fwdUpload'])){

                            echo "<script>$('#dialog').dialog({
                                modal: true,
                                overlay: {
                                    opacity: 0.7,
                                    background: 'black'
                                },
                                buttons: {
                                    
                                    'Done': function() {
                                        $(this).dialog('close');
                                        
                                    }
                                }
                            });
                            
                            </script>";
                        }

                       

            echo "
            <div id='dialog' style='display:none;' title='Upload' >
            <form class='dropzone' id='dropzone_images' enctype='multipart/form-data' method='POST' action='action.php?command=upload'>
            <span class='dz-message'>Drop all your files here or click to upload</span>
            <input type='hidden' name='EventID' value='$_POST[ID]'>
            </form>
           
            </div>
            
            
            ";

        } else {echo "<script>pageEvents();</script>";}

            
        
    }
    break; 

    case "eventName":


        $sql = "SELECT Name FROM Events WHERE EventID = '$_POST[ID]' AND (CreatingID = '$userid' OR concat('-',SharedID,'-') LIKE '%-$userid-%')";
        $result=$conn->query($sql);
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            echo $row['Name'];
        }
    break;



    case "account":
        echo "<button onclick='pageLogout();'>Logout</button><br><br>";
        $sql = "SELECT * FROM Users WHERE UserID = '$userid'";
        $result=$conn->query($sql);
        if($result->num_rows == 1){
            
            $row = $result->fetch_assoc();
            echo "<b>Name: </b>" . $row['FirstName'] . " " . $row['LastName'] . "<br><br>";
            echo "<b>Email: </b>" . $row['Email'] . "<br><br>";
            echo "<b>Subscription: </b> Friends and Family Free for Life Promo - From Ideen<br><br>"; 
        }
    
    break;

    case "logout":
        setcookie("activeSession", '', time()-31556926);
        echo "<script>window.location.href = 'index.php?spt=logout'</script>";
    break;


}




