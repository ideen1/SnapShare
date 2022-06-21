
    //Page Change actions HERE:
    function changePageSearch(){
      loaderShow();
        $( "#body_title" ).html("Search");
        $( "#body_content" ).load("dynamic.php?search", function () { //calback function
          loaderHide();
        });
        window.history.pushState("", "", 'search.php');
    }

    function changePageFriends(){
      loaderShow();
        $( "#body_title" ).html("Friends");
        $( "#body_content" ).load("dynamic.php?friends", function () { //calback function
          loaderHide();
        });
        window.history.pushState("", "", 'friends.php');
    }

    function changePageProfile(){
      loaderShow();
        $( "#body_title" ).html("Profile");
        $( "#body_content" ).load("dynamic.php?profile", function () { //calback function
          loaderHide();
        });
        window.history.pushState("", "", 'profile.php');
    }
    function changePageProfileSpecific(ID){
      loaderShow();
        $( "#body_title" ).html(ID);
        $( "#body_content" ).load("dynamic.php?profile&username=" + ID, function () { //calback function
          loaderHide();
        });
        window.history.pushState("", "", 'profileid.php?ID=' + ID);

    }
    function changePageShowFriends(ID){
      loaderShow();
        $( "#body_title" ).html(ID + "s Friends");
        $( "#body_content" ).load("dynamic.php?profile_friends&username=" + ID, function () { //calback function
          loaderHide();
        });

    }

    function changePageRequests(){
      loaderShow();
        $( "#body_title" ).html("Friend Requests");
        $( "#body_content" ).load("dynamic.php?requests", function () { //calback function
          loaderHide();
        });
        window.history.pushState("", "", 'friends.php');
    }
    function changePagePlans(){
      loaderShow();
        $( "#body_title" ).html("Plans:");
        //alert("The Plan feature is not yet available. For now, add friends!");
        $( "#body_content" ).load("dynamic.php?plans", function () { //calback function
          loaderHide();
        });
        window.history.pushState("", "", 'plans.php');
    }
    function changePagePlanCreate(friend = '', id = ''){
      loaderShow();
        $( "#body_title" ).html("New Plan!");

        $( "#body_content" ).load("dynamic.php?planCreate&friend=" + friend + "&friendid=" + id, function () { //calback function
          loaderHide();
        });
        window.history.pushState("", "", 'createplan.php');
    }
    function changePagePlanView(ID, fresh){
      loaderShow();
        $( "#body_title" ).html("View Plan:");
        //alert("The Plan view feature is not yet available. For now, add friends!");
        $( "#body_content" ).load("dynamic.php?viewPlan=" + ID + "&fresh=" + fresh, function () { //calback function
          loaderHide();
        });
        window.history.pushState("", "", 'view.php?ID=' + ID);
    }
    function changePageInvitations(ID){
      loaderShow();
        $( "#body_title" ).html("Messages:");
        //alert("The Plan view feature is not yet available. For now, add friends!");
        $( "#body_content" ).load("dynamic.php?invitations", function () { //calback function
          loaderHide();
        });
        window.history.pushState("", "", 'messages.php?ID');
    }

    function changePageEditProfile(){
      loaderShow();
        $( "#body_title" ).html("Edit Profile");

        $( "#body_content" ).load("dynamic.php?edit_profile", function () { //calback function
          loaderHide();
        });
        window.history.pushState("", "", 'edit.php');
    }

    function changePageReferUser(ID){
      loaderShow();
        $( "#body_title" ).html("Your friend is on LinkUp!");

        $( "#body_content" ).load("dynamic.php?refer_user?id = " + ID, function () { //calback function
          loaderHide();
        });
        window.history.pushState("", "", 'friends.php');
    }

    function changePageWelcome(ID){
      loaderShow();
        $( "#body_title" ).html("");

        $( "#body_content" ).load("dynamic.php?welcome", function () { //calback function
          loaderHide();
        });
        window.history.pushState("", "", 'sharefriends.php');
    }

    function notification(ID, type = 1){
      
      document.getElementById('notdot' + ID).style.opacity = "1";
      if(type == 0){
        document.getElementById('notdot' + ID).style.opacity = "0";
      }
    }



    //Button Actions HERE:

        function friendChange(ID){
          loaderShow();
            $("#friend_button").load('dynamic.php?add_friend=' + ID, function () { //calback function
              loaderHide();
            });
        }

        function acceptFriend(ID, ele){
          loaderShow();
          $(ele).load('dynamic.php?accept=' + ID, function () { //calback function
            loaderHide();
          });
        }

        function declineFriend(ID, ele){
          loaderShow();
          $(ele).load('dynamic.php?declineFriend=' + ID, function () { //calback function
            loaderHide();
          });
        }

          $(document).ready(function() {
          $('.accept_friend').click(function(event) {
            loaderShow();
            var ID = event.target.id;
            $(this).load('dynamic.php?accept=' + ID, function () { //calback function
              loaderHide();
            });

            });
          });


          $(document).ready(function() {
          $('.decline_friend').click(function(event) {
            loaderShow();
            var ID = event.target.id;
            $(this).load('dynamic.php?declineFriend=' + ID, function () { //calback function
              loaderHide();
            });

            });
          });


        function removeFriend(ID, PROFILE){
          
          if(confirm('Are you sure you want to unfriend this friend?')){
            loaderShow();
          $(".profile_buttons").load('dynamic.php?removeFriend=' + ID, function () { //calback function
            loaderHide();
          });
          setTimeout(
              function()
              {
                changePageProfileSpecific(PROFILE);
              }, 1000);

        }

        }

        function deletePlan(ID){
            if(confirm("Are you sure you want to delete this plan?")){
      loaderShow();
        $( "#body_title" ).html("Deleting Plan...");

        $( "#body_content" ).load("dynamic.php?deletePlan=" + ID, function () { //calback function
          loaderHide();
          changePagePlans();
        });
            changePa
        window.history.pushState("", "", 'plans.php');
    }
    }

        function popNotification (title, value, color, id){
          $("#notification_title").html(title);
            $("#notification_content").html(value);
            $(".alert").attr("style", "display:block; background-color: " + color);
            $(".closebtn").attr("onclick", "dismissNotification(this, " + id + ");");

          
        }

     function dismissNotification(itm ,ID){

      var CookieDate = new Date;
    CookieDate.setFullYear(CookieDate.getFullYear() + 10);

      var expires = " expires="+ CookieDate.toGMTString()

      itm.parentElement.style.display='none'; 
      document.cookie='messageDismiss' + ID + '=1;' + expires + ';';
     }

     
//LOAD SHOW
    function loaderShow(){
      $('.loading').show();
    
    }

    function loaderHide(){
      $('.loading').hide("slide");
    
    }

  //UI CONFIRMS
  function logoutConfirm(){
    

  $( function() {
    $( "#dialog-confirm" ).dialog({
      title: "Logout:",
      resizable: false,
      closeOnEscape: false,
      height: "auto",
      width: 300,
      modal: true,
      buttons: {
        "All": function() {
          window.location = "login.php?purge";
        },
        "This Only": function() {
          window.location = "login.php?logout";
        }
      },
      open: function() {
        $(this).parents('.ui-dialog-buttonpane button:eq(1)').focus(); 
      }
    });
  } );

  $( "#dialog_text" ).html("Would you like to logout from this device or all?");
    //$( "#dialog-confirm" ).attr("title", "Logout:");
    $( "#dialog-confirm" ).css('display', 'block');
  }

  function betterDays(ID){
    

    $( function() {
      $( "#dialog-confirm" ).dialog({
        title: "What works for you?",
        resizable: false,
        closeOnEscape: false,
        height: "auto",
        width: "auto",
        modal: true,
        buttons: {
          "It's Okay": function() {
            window.location = "view.php?ID=" + ID;
          },
          "Send Days": function() {
            
            window.location = "messages.php?days=" + day1 + "&ID=" + ID;
          }
        },
        open: function() {
          $(this).parents('.ui-dialog-buttonpane button:eq(1)').focus(); 
        }
      });
    } );
  
    $( "#dialog_text" ).html("Since none of the dates work for you, give us something that does. We'll ask the others and try our best to make it work.<br><br><div class='form-field'><input id='date' class='datepicker' name='date' type='text' readonly='true' required /><label for='date' >Date that works</label></div><!--<button onclick=betterDaysAdd(1);>Add Another Date</button>-->");
      
    //$( "#dialog-confirm" ).attr("title", "Logout:");
      $( "#dialog-confirm" ).css('display', 'block');
    }

  
  
    function betterDaysAdd(number){
      var new_numb = number + 1;
      $( "#dialog_text" ).append("<br><br><div class='form-field'><input id='date" + number + "' class='datepicker' name='date' type='text' readonly='true' required /><label for='date" + number + "' >Date that works</label></div><button onclick=betterDaysAdd(" + new_numb + ");>Add Another Date</button>");
      

    $('#date' + number).datepicker({
          dateFormat: 'yy-mm-dd', 
    onSelect: function(date) {
      $('[for=date]').css('font-size', '14px');
      $('[for=date]').css('top', '-28px');
      $('[for=date]').css('color', '#34c8db');
  },
    beforeShow: function() {
      setTimeout(function(){
          $('.ui-datepicker').css('z-index', 99999999999999);
      }, 0);
      }, 
    minDate:0
  });
    
    }

    function alternatePrompt(altID, friendName, date){
    
     
      $( function() {
        $( "#dialog-confirm" ).dialog({
          title: "Help " + friendName + " out!",
          resizable: false,
          closeOnEscape: false,
          height: "auto",
          width: "auto",
          modal: true,
          buttons: {
            "Yeah": function() {
              window.location = "view.php?altreply=yes&altid=" + altID;
            },
            "Nope": function() {
              
              window.location = "view.php?altreply=no&altid=" + altID;
            }
          },
          open: function() {
            $(this).parents('.ui-dialog-buttonpane button:eq(1)').focus(); 
          }
        });
      } );
    
      $( "#dialog_text" ).html("We got ur RSVP but "+ friendName +" can't make ANY of these dates! They have offered " + date + " as an alternative...Does it work for you? <br><br>");
        
      //$( "#dialog-confirm" ).attr("title", "Logout:");
        $( "#dialog-confirm" ).css('display', 'block');
      }

    function checkConnection(){

    //LOAD ERROR HANDLER
    $.ajax({
          url:"dynamic.php",  
          success:function(data) {
             $(".errorbar").hide();
          },
          error: function(data){
             
            $(".errorbar").show();
          }
        });
    
    }
    checkConnection();

    setInterval(function(){  checkConnection(); }, 5000);
    //setInterval(function(){  loaderHide(); }, 1500);

    //Navigation Aider Script:
    window.onpopstate = function (e) {
      location.reload();
    }


    //UI Elements
    //RSVP CHECKBOXES
    $(".rsvpyesall").on("click", function() {
      $(".rsvp_checkbox").prop("checked", true);
      
    });

    $(".rsvpnoall").on("click", function() {
      $(".rsvp_checkbox").prop("checked", false);
      
    });
  
  //DATE PICKER FOR betterDays();
    $('.datepicker').each(function(){
      $(this).datepicker({
        dateFormat: 'yy-mm-dd', 
  onSelect: function(date) {
    $('[for=date]').css('font-size', '14px');
    $('[for=date]').css('top', '-28px');
    $('[for=date]').css('color', '#34c8db');
    //Set Variable to send
    day1 = date;

},
  beforeShow: function() {

    setTimeout(function(){
        $('.ui-datepicker').css('z-index', 99999999999999);
    }, 0);
    }, 
  minDate:0
});
  });

  $('.datepicker').focus();


  function shareNative(name, url, text){
    if (navigator.share) {
      navigator.share({
        title: name,
        url: url,
        text
      }).then(() => {
        console.log('Thanks for sharing!');
      })
      .catch(console.error);
    } else {
      alert("Your device does not support smart-sharing. Manually send them the link using your normal share button.");
    }
  }
  

   

    
  