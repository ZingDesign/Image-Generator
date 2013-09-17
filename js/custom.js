//console.log('custom.js loaded');

Dropzone.options.myAwesomeDropzone = {
    addRemoveLinks: true,
    acceptedFiles: ".JPG,.JPEG,.jpg,.jpeg,.png",
    init: function() {
        this.on("addedfile", function(file) { console.log("Added file."); })
//            .on("complete", function(file) { console.log("Complete"); })
//            .on("drop", function(e) {console.log("Drop");})
            .on("removedfile", function(file) {
//                console.log("file removed");
//                console.log(file.name);
                var removeFile = {
                    'remove_file': {
                        'current_file':file.name
                    }
                };
                $.post('file-upload.php',
                    removeFile,
                    function(response) {
//                        console.log(response);
                    }
                )
            })
            .on("sending", function(file, xhr, formData) {
//                console.log(file);
//                console.log(formData);
            })
            .on("selectedfiles", function(file) {
//                console.log(file);
            });
//            .on("totaluploadprogress", function(e) { console.log(e); });
    }
};

//Init tooltip
$('.help-message').tooltip({
    placement: "right",
    trigger: "hover focus click"
});

$('input[name="preview"]').click(function(e){
    e.preventDefault();
    $(this).val("1");
//    return true;
    $.post(
        'preview.php',
        {
            'preview_images': {
                'image': "image-01.jpg"
            }
        },
        function(response) {
            $('#preview-box').html(response);
        }
    )
});

//$('input[name="generate"]').click(function(e) {
//    e.preventDefault();
////    var parentForm = $("#my-awesome-dropzone");
////    var currAction = parentForm.attr("action");
//    var formData = $("form#img-config").serialize();
//    console.log(formData);
//
//    $.post(
//        "generate.php",
//        formData,
//        function(data, textStatus, jqXHR) {
//            console.log(textStatus);
//            console.log(data);
//        }
//    )
//});

var mainDiv = $('[role="main"]');
var loadingIcon = $('<div class="loading-icon">Loading...</div>');

$('#img-config').on("submit", function(e) {
    e.preventDefault();
//    var parentForm = $("#my-awesome-dropzone");
//    var currAction = parentForm.attr("action");
    var formData = $(this).serialize();
    console.log(formData);
    showLoader();

    $.post(
        "generate.php",
        formData,
        function(data, textStatus) {
            console.log(textStatus);
            console.log(data);
            if(textStatus == "success") {
                hideLoader();
                window.location = data;
            }
            else {
                errorMessage.html("There was a problem connecting to the server, please try again shortly")
            }
        }
    )
});

function showLoader() {
    if(mainDiv.find(".loading-icon").length === 0) {
        mainDiv.append(loadingIcon);
    }
    $('.loading-icon').fadeIn();
}

function hideLoader() {
    $('.loading-icon').fadeOut();
}