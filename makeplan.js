$(function() {
            $( "#people" ).autocomplete({
                source: 'lookup.php?fill=PEOPLE',
                html: true,
                open: function(event, ui) {
                    $(".ui-autocomplete").css("z-index", 1000);

                },
                select: function(event, ui) {

                   
                    
                    function addToPeopleList(){
                    var list1 = $('#invitees').html();
                    var new1 = "<div id='icon_" + ui.item.Email + "' style='display:inline-block; padding:2px; border:1px solid black;'><img src='" + ui.item.IMAGE + "' height='40' style='position:relative; right:0px;'><span onclick=removeFromPlan('" + ui.item.Email + "'); style='position:relative;top:-10px; left:35px; background-color:white; opacity:0.7; border-radius:2px;'>&#10005;</span><br><span style='font-size:12px; '>" + ui.item.FNAME + "<br>" + ui.item.Email + "</span></div>";
                    $('#invitees').html(list1 + new1);


                    var list2 = $('#people_id').val();
                    var new2 = ui.item.Email;
                    $('#people_id').val(list2 + "-" + new2 );



                    //if(confirm("Would you like an email when your song plays?")){
                       // var pnumber = prompt("Enter email:");


                   // }else{
                        //var url = encodeURIComponent( ui.item.track);
                           // $( "#thanks" ).load("request.php?title=" + url + "&number=" + pnumber );

                  document.activeElement.blur();
                    $("ul.ui-autocomplete").hide();
                    }


                    if (ui.item.Status == 'NEW'){
                        loaderShow();
                        $.ajax({
                            url : "action.php?command=user&email=" + ui.item.Email,
                            type: "GET",
                            
                        }).done(function(response){ //
                            addToPeopleList();
                            loaderHide();
                        });
                        
                    }

                    if (ui.item.Status == 'VALID'){
                        addToPeopleList();
                    }

                    if (ui.item.Status == 'INVALID'){
                        alert("Just enter the whole email address and we'll take care of the rest");
                    }
                    $("#people").focus();

                },
                search: function (e, u) {
                    $('#loader').addClass('loader');


                },
                response: function (e, u) {
                    $('#loader').removeClass('loader');
                },
                close : function (event, ui) {
                        if (!$("ul.ui-autocomplete").is(":visible")) {
                            $("ul.ui-autocomplete").show();
                        }
                    }
                })
                .autocomplete( "instance" )._renderItem = function( ul, item ) {
                return $( "<li><div><span style='display:inline-block; position:relative; left:40px;'>"+item.Email+"<br><i >" + item.FNAME + " " + item.LNAME + "</i><img class='profile_image' height='50' style='position:relative; left: -25px; display:inline-block; top:-25px; ' src='" + item.IMAGE +"'> </span></div></li>" ).appendTo( ul );
              };

            });

        function removeFromPlan(ID){
            var list_old = $('#people_id').val();
            var new_list = list_old.replace('-' + ID, "");
            $('#people_id').val(new_list);

            $('#icon_' + ID).remove();
            }



            $("#newForm").submit(function(event){
                event.preventDefault(); //prevent default action 
                var post_url = $(this).attr("action"); //get form action url
                var request_method = $(this).attr("method"); //get form GET/POST method
                var form_data = $(this).serialize(); //Encode form elements for submission
                
                $.ajax({
                    url : post_url,
                    type: request_method,
                    data : form_data
                }).done(function(response){ //
                    $("#body_content").html(response);
                });
});