//Global Image Upload Function
$(document).on('change', '.image-upload', function() {

    //Set the entity type, for example 'articleBlock' and unique ID.
    var entity_id = $(this).data('entity-id');
    var entity_type = $(this).data('entity-type');

    //Image Area to Crop
    var container = $('#image-' + entity_type + '-uploader-' + entity_id);
    var cropImage = $('#crop-image-' + entity_type + '-' + entity_id);
    var previewImage = $('#image-' + entity_type + '-' + entity_id);
    var uploadBtn = $('#image-' + entity_type + '-upload-btn-' + entity_id);
    var controls = $('#crop-' + entity_type + '-controls-' + entity_id);
    var aspect_ratio = $(this).data('aspect-ratio');

    if(aspect_ratio == null) {
        aspect_ratio = 1.77;
    }

    // Destroy old Crop just incase one is in progress after new upload.
    cropImage.cropper('destroy');

    var input = this;
    var url = this.value;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();

    if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {

        var reader = new FileReader();

        reader.onload = function (e) {
            cropImage.attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);

        // Now Crop Image
        setTimeout( function() {
            cropImage.cropper({
                aspectRatio: aspect_ratio,
                viewMode: 2,
                responsive: true,
                checkOrientation: true,
                center: true,
                // aspectRatio: 16 / 9,
                crop: function(event) {
                    cropImage.show();
                    //Hide the Preview Image and Upload Button.
                    previewImage.hide();
                    uploadBtn.hide();
                    controls.show();
                    container.addClass('cropping');
                }
            });

            // Get the Cropper.js instance after initialized
            var cropper = cropImage.data('cropper');
        }, 50);
    }
    else{
        console.log('there was an error');
        cropImage.attr('src', 'http://via.placeholder.com/1068x500');
        container.removeClass('cropping');
    }
});

//Crop Confirmation and Upload to the Cloud
$(document).on('click', '.image-crop-accept', function(e) {
    e.preventDefault();

    //Set the entity type, for example 'articleBlock' and unique ID.
    var entity_id = $(this).data('entity-id');
    var entity_type = $(this).data('entity-type');
    var remotePath = $(this).data('remote-path');

    //Image Area to Crop
    var container = $('#image-' + entity_type + '-uploader-' + entity_id);
    var cropImage = $('#crop-image-' + entity_type + '-' + entity_id);
    var previewImage = $('#image-' + entity_type + '-' + entity_id);
    var uploadBtn = $('#image-' + entity_type + '-upload-btn-' + entity_id);
    var upload = $('#image-' + entity_type + '-upload-' + entity_id);
    var controls = $('#crop-' + entity_type + '-controls-' + entity_id);
    var spinner = $('#crop-' + entity_type + '-spinner-' + entity_id);
    var complete = $('#crop-' + entity_type + '-complete-' + entity_id);

    var originalFilename = upload.val().replace(/C:\\fakepath\\/i, '');


    cropImage.cropper('getCroppedCanvas', {
        maxWidth: 3840, //4K Resolution Max Upload for Article Block Images
        fillColor: '#fff',
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high'
    }).toBlob(function (imageBlock) {

        var formData = new FormData();
        formData.append('croppedImage', imageBlock);
        formData.append('originalName', originalFilename);
        formData.append('entityType', entity_type);
        formData.append('entityId', entity_id);
        formData.append('remotePath', remotePath);

        $.ajax('/admin/image-upload', {
            method: "POST",
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            beforeSend: function () {
                //Destroy the cropper
                cropImage.cropper('destroy'); // Stop the Cropper
                cropImage.hide(); // Hide the crop Image
                previewImage.show(); // Show the old image again
                //Hide all the controls
                container.removeClass('cropping');
                controls.hide();
                complete.hide();
                //Show the spinner
                spinner.show();
            },
            success: function (response) {
                console.log('Upload Success');
                console.log(response);
                upload.val(''); // Clear the input field

                //Update the preview image with the new one
                previewImage.attr('src', response.new_path);
                cropImage.hide();
                setTimeout(function(){
                    spinner.hide();
                    complete.show();
                    uploadBtn.show();
                }, 500);
            },
            error: function (response) {
                console.log('Upload error');
                console.log(response);
                cropImage.cropper('destroy'); // Stop the Cropper

                cropImage.hide(); // Hide the crop Image
                previewImage.show(); // Show the old image again

                //Hide all the controls
                container.removeClass('cropping');
                controls.hide();
                complete.hide();
                //Show the spinner
                spinner.hide();
            }
        });
    }, "image/jpeg");
});

//Article Builder Image Upload Destroy
$(document).on('click', '.image-crop-destroy', function(e) {
    e.preventDefault();

    console.log('destroy pressed');

    //Set the entity type, for example 'articleBlock' and unique ID.
    var entity_id = $(this).data('entity-id');
    var entity_type = $(this).data('entity-type');

    //Image Area to Crop
    var container = $('#image-' + entity_type + '-uploader-' + entity_id);
    var cropImage = $('#crop-image-' + entity_type + '-' + entity_id);
    var previewImage = $('#image-' + entity_type + '-' + entity_id);
    var uploadBtn = $('#image-' + entity_type + '-upload-btn-' + entity_id);
    var controls = $('#crop-' + entity_type + '-controls-' + entity_id);
    var upload = $('#image-' + entity_type + '-upload-' + entity_id);


    container.removeClass('cropping');
    cropImage.cropper('destroy');
    upload.val(''); // Clear the input field
    controls.hide();
    cropImage.hide();
    previewImage.show();
    uploadBtn.show();
});