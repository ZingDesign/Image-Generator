//console.log('custom.js loaded');

Dropzone.options.myAwesomeDropzone = {
    addRemoveLinks: true,
    acceptedFiles: ".JPG,.JPEG,.jpg,.jpeg,.png",
    init: function() {
        this.on("addedfile", function(file) { console.log("Added file."); })
//            .on("complete", function(file) { console.log("Complete"); })
//            .on("drop", function(e) {console.log("Drop");})
            .on("removedfile", function(file) {
                console.log("file removed");
//                console.log(file.name);
                var removeFile = {
                    'remove_file': {
                        'current_file':file.name
                    }
                };
                $.post('file-upload.php',
                    removeFile,
                    function(response) {
                        console.log(response);
                    }
                )
            })
            .on("sending", function(file, xhr, formData) {
//                console.log(file);
//                console.log(formData);
            })
            .on("selectedfiles", function(file) {
                console.log(file);
            });
//            .on("totaluploadprogress", function(e) { console.log(e); });
    }
};


$('.help-message').tooltip({
    placement: "right",
    trigger: "hover focus click"
});

$('button[name="preview"]').click(function(e){
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