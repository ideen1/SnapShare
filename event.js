
lightbox.option({
                
    'alwaysShowNavOnTouchDevices': true,
    'imageFadeDuration': 50,
    'resizeDuration': 200,
    'wrapAround': true
  })

$("#upload_button").click(function(){


    $('#dialog').dialog({
        modal: true,
        overlay: {
            opacity: 0.7,
            background: "black"
        },
        buttons: {
            
            "Done": function() {
                $(this).dialog('close');
                
            }
        }
    });

});


Dropzone.autoDiscover = false;

var myDropzone = new Dropzone('#dropzone_images', {       
    paramName: "images", 
    maxFilesize: 20, 
    parallelUploads: 5,
    uploadMultiple: true,
    autoProcessQueue: true,
    success: function(value, response){
        pageEvent(EventID);
        
    }
});

$(window).bind('beforeunload', function() {
    var dz=$("#dropzone_images")
    if (dz.length && dz[0].dropzone && dz.dropzone.getUploadingFiles().length>0){
        return 'Warning...';
    }
}); 


// init Masonry
var $grid = $('.grid').masonry({
    itemSelector: '.grid-item',
    columnWidth: '.grid-sizer',
    gutter: 10,
    
  });
  // layout Masonry after each image loads
  $grid.imagesLoaded().progress( function() {
    $grid.masonry('layout');
  });