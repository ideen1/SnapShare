<?php

require("initialize.php");


    if(isset($_GET['invite']) && !isset($_GET['spt'])){
        if(!isset($_COOKIE['activeSession'])){
            
            $invite_script = "pageEventInvite('$_GET[invite]');popNotification('You have been invited to view and add your photos to this event using SnapShare Photos, Login or SignUp to view the rest of the pictures and upload!', 'orange');";

        } elseif(checkLogin()){
            $invite_script = "pageEventInvite('$_GET[invite]');";
            
        } else{
            $invite_script = "pageEventInvite('$_GET[invite]');popNotification('You have been invited to view and add your photos to this event using SnapShare Photos, Login or SignUp to view the rest of the pictures and upload!', 'orange');";
        }
        
        
    }

//echo generateID("IMAGE");

//SSL REDIRECT
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
  $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: ' . $location);
  exit;
}

if(isset($_COOKIE['activeSession'])){
    setcookie("activeSession", $_COOKIE['activeSession'], time()+31556926);

}

/*
if(!isset($_COOKIE['activeSession'])){

            if(isset($_GET['invite'])){
                
                $ID = lookupID($_GET['invite']);
                
                $sql = "SELECT * FROM Events WHERE EventID = '$_POST[ID]' AND concat('-',SharedID,'-') LIKE '%-$ID-%'";
                $limitsql = "LIMIT 5";

                if(isset($_GET['invite'])){
                    echo "<script>popNotification();</script>";
                }
    
                
            }
        
        }

    $page = basename($_SERVER['PHP_SELF']);
    echo "<script>window.location= 'interstitial.php?forward=$page' </script>";

} else{

}
*/

$page = $_GET['spt'];
?>

<!DOCTYPE>
<html>
<head>



  <!-- BEGIN APPLE TOUCH -->
<link rel="apple-touch-icon" href="/favicon.ico">
<link rel="icon" type="image/png" href="/favicon.ico">

<meta name="apple-mobile-web-app-title" content="SnapShare">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="white">
<!-- END APPLE TOUCH -->


<meta name="viewport" content="width=device-width, user-scalable=no" />
<title>SnapShare - Share Pics Fast</title>


<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.js"></script>


<link rel="stylesheet" href="linkup4.css">
<link rel="stylesheet" href="Assets/lightbox.css">
<link rel="stylesheet" href="Assets/dropzone.css">
<script src="main.js"></script>
<script src="lookup.js"></script>
<script src='Assets/lightbox.js'></script>
<script src="Assets/dropzone.js"></script>
    


<span id='dump'></span>

</head>

<body>
<header>
    
<div>

    <p><img class="logo centered" src="Assets/Logo.png" onclick="window.location.reload();" style='float:left;'> </p>
    <p style='float:right; font-size:10px; position:relative; bottom:0px;'>                                                                                                                                                                                                                                                                                      <br>by Ideen Web Systems</p>



<div data-role="page" id="index">
</div>
    <div class="mobile_nav_bar">
 
    <br><br><br><br>
<ul>
<?php 
if(checkLogin() == true){ ?>
<li><a onclick="pageUpload();" <?php if($page == "new"){/*echo "class='active'"; */}?>><img src="Assets/upload.png"><span>New Event</span><span class="ul_dot" id="notdot1"></span></a></li>
  <li><a onclick="pageEvents();" <?php if($page == "events"){/*echo "class='active'"; */}?>><img src="Assets/event.png"><span>My Events</span><span class="ul_dot" id="notdot2"></span></a></li>
<li><a onclick="pageAccount();" <?php if($page == "account"){/*echo "class='active'"; */}?>><img src="Assets/account.png"><span>Account</span><span class="ul_dot" id="notdot3"></span></a></li>
<?php } else{ ?>
<li><a onclick="pageLogin();" <?php if($page == "new"){/*echo "class='active'"; */}?>><img src="Assets/login.png"><span>Login</span><span class="ul_dot" id="notdot1"></span></a></li>
  <li><a onclick="pageSignup();" <?php if($page == "events"){/*echo "class='active'"; */}?>><img src="Assets/signup.png"><span>Sign Up</span><span class="ul_dot" id="notdot2"></span></a></li>


<?php } ?>

</ul>

<div class='errorbar'>Couldn't Refresh...</div>
</div>
<br>
<div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  <span id="notification_content"></span>
</div>
    </header>

    <div class="body_title" ><h3 id="body_title">Welcome <?php echo getName($userid);?></h3></div>

    <div class="body_content" id="body_content">
        
    <noscript>SnapShare requires JavaScript to run properly. Please enable then reload.</noscript>
    
        


</div>


<div class="loading">Loading&#8230;(Thinking Very Hard)</div>


<script>


    function pageEvents(){
        loaderShow();
        $.post('dynamic.php', {page: 'events'},
        function(output) {
            $("#body_content").html(output);
            $("#body_title").html("Events");
            window.history.pushState("", "", '?spt=events');
            loaderHide();
            
            
        });
    }

    function pageAccount(){
        loaderShow();
        $.post('dynamic.php', {page: 'account'},
        function(output) {
            $("#body_content").html(output);
            $("#body_title").html("Account");
            window.history.pushState("", "", '?spt=account');
            loaderHide();
            
            
        });
    }

    function pageUpload(){
        loaderShow();
        $.post('dynamic.php', {page: 'new'},
        function(output) {
            $("#body_content").html(output);
            $("#body_title").html("New Event");
            window.history.pushState("", "", '?spt=new');
            loaderHide();
            
        });

    }

    function pageLogin(){
        loaderShow();
        

        <?php if(isset($_GET['invite'])){ ?> 

            $.post('dynamic.php', {page: 'login', invite: "<?php echo $_GET['invite']; ?>"},
            function(output) {
            $("#body_content").html(output);
            $("#body_title").html("Login to Plan");
            
           
            
            
            });
            
        <?php } else{?>

            $.post('dynamic.php', {page: 'login'},
            function(output) {
                $("#body_content").html(output);
                $("#body_title").html("Login");
                
                window.history.pushState("", "", '?spt=login');
                
                
            });
        
        
        <?php }?>

loaderHide();

    }

    function pageSignup(){
        loaderShow();
        

        <?php if(isset($_GET['invite'])){ ?> 
            $.post('dynamic.php', {page: 'signup', invite: "<?php echo $_GET['invite']; ?>"},
        function(output) {
            $("#body_content").html(output);
            $("#body_title").html("Sign Up to Plan");
            
        });
            
    <?php } else{?>

        $.post('dynamic.php', {page: 'signup'},
        function(output) {
            $("#body_content").html(output);
            $("#body_title").html("Sign Up");
            
            window.history.pushState("", "", '?spt=signup');
            
            
        });
        
        
        <?php }?>

loaderHide();

    }

    function pageEvent(ID, Invite){
        loaderShow();

        window.history.pushState("", "", '?spt=event&sptid=' + ID);


        $.post('dynamic.php', {page: 'event', ID: ID},
        function(output) {
            $("#body_content").html(output);

            
        });
        loaderHide();

        $.post('dynamic.php', {page: 'eventName', ID: ID},
        function(output) {
            
            $("#body_title").html(output);
            
        });

        
    }

    function pageEventInvite(ID){
        loaderShow();

        

        //window.history.pushState("", "", '?spt=invite&sptid=' + ID);


        $.post('dynamic.php', {page: 'invite', ID: ID},
        function(output) {
            $("#body_content").html(output);

            
        });
        loaderHide();

        $.post('dynamic.php', {page: 'eventName', ID: ID},
        function(output) {
            
            $("#body_title").html(output);
            
        });

        
    }


    function pageEventFwdUpload(ID){
        loaderShow();
        
        window.history.pushState("", "", '?spt=event&sptid=' + ID);
        $("#body_title").html("");


        $.post('dynamic.php?fwdUpload', {page: 'event', ID: ID},
        function(output) {
            $("#body_content").html(output);

            
        });
        loaderHide();

        $.post('dynamic.php', {page: 'eventName', ID: ID},
        function(output) {
            
            $("#body_title").html(output);
            
        });

        
    }

    function download(ID){
       
        window.open("action.php?command=download&ID=" + ID);

            
        
    }

    function pageLogout(){
       
        loaderShow();
        $.post('dynamic.php', {page: 'logout'},
        function(output) {
            $("#body_content").html(output);
            $("#body_title").html("Logging Out...");
            window.history.pushState("", "", '?spt=events');
            loaderHide();
            
        });

           
       
   }

    function popNotification (value, color){
          
            $("#notification_content").html(value);
            $(".alert").attr("style", "display:block; background-color:" + color);
            //$(".closebtn").attr("onclick", "dismissNotification(this, " + id + ");");

          
        }



    <?php
            

            if($page == 'account'){echo "pageAccount();";}
            if($page == 'events'){echo "pageEvents();";}
            if($page == 'login'){echo "pageLogin();";}
            if($page == 'signup'){echo "pageSignup();";}
            if($page == 'logout'){echo "pageLogin();popNotification('Successfully Logged Out!', 'green');";}

            if(empty($_GET['spt'])){

            if(!empty($_GET['invite'])){
                if($page == 'event'){echo "pageEvent('$_GET[sptid]', '$_GET[invite]');";}
            } else{
                if($page == 'event'){echo "pageEvent('$_GET[sptid]');";}
            }
        }

            if($page == 'new'){echo "pageUpload();";}
            echo $invite_script;

            if(isset($_GET['alert'])){

                if($_GET['alert'] == "LoggedEdit"){echo "popNotification('Logged in! You can now upload pictures to this event and view all of them!', 'green');";}
                if($_GET['alert'] == "Signed"){echo "popNotification('Successfully Signed Up!', 'green');";}
                if($_GET['alert'] == "LoggedIn"){echo "popNotification('Successfully Logged in!', 'green');";}
                if($_GET['alert'] == "NoAccount"){echo "popNotification('You have not signed up yet', 'orange');";}
                if($_GET['alert'] == "InvalidLogin"){echo "popNotification('Incorrect credentials!', 'red');";}
                if($_GET['alert'] == "AccountAlready"){echo "popNotification('You have already made an account, please login', 'blue');";}
                
            }

        ?>

    </script>


    </body>

</html>
