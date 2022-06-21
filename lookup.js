$(function() {
            $( "#searchbox" ).autocomplete({
                source: 'lookup.php?fill=SEARCH',
                html: true,
                open: function(event, ui) {
                    $(".ui-autocomplete").css("z-index", 1000);

                },
                select: function(event, ui) {


                        $( "#body_title" ).html(ui.item.USERNAME);
                        $( "#body_content" ).load("dynamic.php?profile&username=" + ui.item.USERNAME);

                    //if(confirm("Would you like an email when your song plays?")){
                       // var pnumber = prompt("Enter email:");


                   // }else{
                        //var url = encodeURIComponent( ui.item.track);
                           // $( "#thanks" ).load("request.php?title=" + url + "&number=" + pnumber );

                  document.activeElement.blur();
                    $("ul.ui-autocomplete").hide();


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
                return $( "<li><div><span>"+item.USERNAME+"<br><i>" + item.NAME + "</i><img class='profile_image' height='50' style='float:right; top:-25px; position:relative;' src='" + item.IMAGE +"'> </span></div></li>" ).appendTo( ul );
              };

            });

            $(function() {
                $( "#plansearchbox" ).autocomplete({
                    source: 'lookup.php?fill=PLANS',
                    html: true,
                    open: function(event, ui) {
                        $(".ui-autocomplete").css("z-index", 1000);
    
                    },
                    select: function(event, ui) {
    
                        changePagePlanView(ui.item.ID);
    
                        //if(confirm("Would you like an email when your song plays?")){
                           // var pnumber = prompt("Enter email:");
    
    
                       // }else{
                            //var url = encodeURIComponent( ui.item.track);
                               // $( "#thanks" ).load("request.php?title=" + url + "&number=" + pnumber );
    
                      document.activeElement.blur();
                        $("ul.ui-autocomplete").hide();
    
    
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
                    return $( "<li><div><span>"+item.NAME+"<br><i>" + item.RSVPSTATUS + " Replied</i><img class='profile_image' height='50' style='float:right; top:-25px; margin-right:-10px; position:relative;' src='" + item.IMAGE +"'> </span></div></li>" ).appendTo( ul );
                  };
    
                });
