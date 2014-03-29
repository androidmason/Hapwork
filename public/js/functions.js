


function showRequest(formData, jqForm, options) {
		$("#validation-errors").hide().empty();
		$("#output").css('display','none');
		return true;
		} 
	
	function showResponse(response, statusText, xhr, $form)  {
    if(response.success == false)
    {
        var arr = response.errors;
        $.each(arr, function(index, value)
        {
            if (value.length != 0)
            {
                $("#validation-errors").append('<div class="alert alert-error"><strong>'+ value +'</strong><div>');
            }
        });
        $("#validation-errors").show();
    } else {
         $("#output").html("<img src='"+response.file+"' />");
         $("#output").css('display','block');
    }
	}
	uploadImage: function()
{
    var _this = this,
        $imgInput = $('#image-upload');

    this.cache.$imgPreview.hide();
    this.cache.$imgOriginal.hide();
    $('.img-data').remove(); //remove any previous image data

    $.ajaxFileUpload(
    {
        url: _this.settings.uploadImageUrl,
        secureuri: false,
        fileElementId: 'image-upload',
        dataType: "json",
        success: function(data)
        {
            console.log(data);
            _this.cache.$imgPreview.attr('src',data.thumb.img_src);
            _this.cache.$imgOriginal.attr('src',data.master.img_src);

            //show img data
            _this.cache.$imgPreview.after('<div class="img-data">'+$.objToString(data.thumb)+'</div>');
            _this.cache.$imgOriginal.after('<div class="img-data">'+$.objToString(data.master)+'</div>');
            $('#remove-image-upload').show();
        },
        error: function(xhr, textStatus, errorThrown)
        {
            console.log(xhr, textStatus, errorThrown + 'error');
            return false;
        },
        complete: function()
        {
            //hide loading image
            _this.cache.$form.find('.loading').hide();
            _this.cache.$imgPreview.show();
            _this.cache.$imgOriginal.show();
        }
    });
}
submitForm: function()
{
    /* example of submitting the form */
    var $theForm = $('#submit-plugin-form'),
        formData = $theForm.serialize(); //get form data

    //include video thumb src
    formData += '&image-thumb=' + $('#image-thumb').attr('src');
    $theForm.find(':input').attr('disabled', 'disabled'); //lock form

    $.ajax(
    {
        type: "POST",
        url: 'php/submitForm.php',
        dataType: "json",
        data: formData,
        success: function(ret)
        {
            //...
        },
        error: function(xhr, textStatus, errorThrown)
        {
            console.log(xhr, textStatus, errorThrown + 'error');
            return false;
        }
    });
}
 function closeForm(){
     $(”#messageSent”).show(”slow”);
     setTimeout(’$(”#messageSent”).hide();$(”#contactForm”).slideUp(”slow”)’, 2000);
}

 