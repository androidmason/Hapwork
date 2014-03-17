<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <title>Creatyst</title>
	{{ HTML::style('packages/bootstrap/css/bootstrap.min.css') }}
    {{ HTML::style('css/main.css')}}
	{{ HTML::style('css/slider.css') }}
	{{ HTML::style('css/fbphotobox.css') }}
	<script src="http://code.jquery.com/jquery-1.8.2.min.js" type="text/javascript"></script>
	<script src="http://malsup.github.com/jquery.form.js"></script> 
	{{ HTML::script('js/jquery.carouFredSel-6.0.4-packed.js')}}
	{{ HTML::script('js/fbphotobox.js')}}
	{{ HTML::script('js/functions.js')}}
	<script type="text/javascript">	
			
			$(document).ready(function() {	
			
			var $c = $('#carousel'),
					$w = $(window);

				$c.carouFredSel({
					align: false,
					items: 3,
					scroll: {
						items: 1,
						duration: 8000,
						timeoutDuration: 0,
						easing: 'linear',
						pauseOnHover: 'immediate'
					}
				});

				
				$w.bind('resize.example', function() {
					var nw = $w.width();
					if (nw < 990) {
						nw = 990;
					}

					$c.width(nw * 3);
					$c.parent().width(nw);

				}).trigger('resize.example');
			
			
		$("#carousel img").fbPhotoBox({
			rightWidth: 360,
			leftBgColor: "black",
			rightBgColor: "white",
			footerBgColor: "black",
			overlayBgColor: "#1D1D1D",
			onImageShow: function() {
				$("#carousel img").fbPhotoBox("addTags",
						[{x:0.3,y:0.3,w:0.3,h:0.3}]
				);
				$("#carousel-image-content").html('<div style="font-size:16px;">Hello world</div>'+$(this).attr("src"));
			}
		});
		
		 var options = {
                beforeSubmit:  showRequest,
        success:       showResponse,
        dataType: 'json'
        };
    $('body').delegate('#image','change', function(){
        $('#upload').ajaxForm(options).submit();          
    });

	$('.lightbox').click(function(){
					$('.backdrop, .box').animate({'opacity':'.50'}, 300, 'linear');
					$('.box').animate({'opacity':'1.00'}, 300, 'linear');
					$('.backdrop, .box').css('display', 'block');
				});
 
				$('.close').click(function(){
					close_box();
				});
 
				$('.backdrop').click(function(){
					close_box();
				});
				
	$('a.login-window').click(function() {
		
		// Getting the variable's value from a link 
		var loginBox = $(this).attr('href');

		//Fade in the Popup and add close button
		$(loginBox).fadeIn(300);
		
		//Set the center alignment padding + border
		var popMargTop = ($(loginBox).height() + 24) / 2; 
		var popMargLeft = ($(loginBox).width() + 24) / 2; 
		
		$(loginBox).css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		
		// Add the mask to body
		$('body').append('<div id="mask"></div>');
		$('#mask').fadeIn(300);
		
		return false;
	});
	
	// When clicking on the button close or the mask layer the popup closed
	$('a.close, #mask').live('click', function() { 
	  $('#mask , .login-popup').fadeOut(300 , function() {
		$('#mask').remove();  
	}); 
	return false;
	});
		
	});
		
		</script>

		
  </head>
 
  <body>
	
	<div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <ul class="nav"> 
                @if(!Auth::check())
                     Redirect::to('login');
                @else
                    <li>{{ HTML::link('logout', 'logout') }}</li>
                @endif
                </ul> 
            </div>
        </div>
    </div> 
	
	<div class="container">
        @if(Session::has('message'))
            <p class="alert">{{ Session::get('message') }}</p>
        @endif





<?php $location = base_path().'\public\uploads\\'.$creatyst->username.'\\';
      $path = 'uploads/'.$creatyst->username.'/';
	  $base = 'www.hapwork.com/uploads/';
?>
	@if (File::isDirectory($location))
<?php	
$files = File::allFiles($path);
?>
	@else
<?php
for($x=0;$x<10;$x++)
$files[$x] = 'uploads/default.jpg';
?>
	@endif

<div id="wrap">
	<div id="carousel">
		
		@for($x=0;$x<count($files);$x++)
		<div>
			<?php
			$pos = strpos($files[$x],'\\');
			if ($pos !== false) {
			$files[$x] = substr_replace($files[$x],'/',$pos,strlen('\\'));}
			?>
					<img carousel-src="{{ asset ($files[$x]) }}" src="{{ asset ($files[$x]) }}" alt="fruit1" width="700" height="700" />
					<span>Apple</span>
		</div>
		@endfor
		
		

	</div>
</div>

</div>
 
 <div id="left_pane">

 @if(isset($creatyst->profilepic))
  <?php
 $dp = '/uploads/profilepic/'.$creatyst->username.'/'.$creatyst->profilepic;
 ?>
 <a href="{{asset($dp)}}" target="_blank"><img class="circular" src="{{asset($dp)}}" width="150" height="150"/></a> 
 @else 
 <img class="circular" src="{{asset ('images/default_profile.png') }}" />
 @endif
{{ Form::open(array( 'url' => '/upload','files' => true  )) }}
{{ Form::file('file')}}
{{ Form::hidden('folder', $creatyst->username) }}
{{ Form::submit('Upload Profile') }}
{{ Form::close() }}
<div class="row">
{{ Form::open(array( 'url' => '/multiupload','files' => true  )) }}
{{ Form::file('file',array('multiple'=>true))}}
{{ Form::hidden('folder', $creatyst->username) }}
{{ Form::submit('Upload To Gallery') }}
{{ Form::close() }}
    <div class="span8">
        <!-- Post Title -->
        <div class="row">
            <div class="span8">
                <h1>{{ Str::upper($creatyst->firstname) }} </h1>
				<h1>{{ Str::upper($creatyst->talent) }} </h1>
            </div>
        </div>
        <!-- Post Footer -->
        <div class="row">
            <div class="span3">
                <div id="validation-errors"></div> 
            </div>
            <div class="span5">
                <a href="#login-box" class="login-window"><img  src="{{asset ('images/facebook.png') }}" height="50" width="50"/></a>
				<a href="#login-box" class="login-window"><img  src="{{asset ('images/linkedin.png') }}" height="50" width="50" /></a>
				<a href="#login-box" class="login-window"><img  src="{{asset ('images/blogger.png') }}" height="50" width="50" /></a>
            </div>
        </div>
    </div>
</div>

</div>
<div id="login-box" class="login-popup">
        <form method="post" class="signin" action="registration.php">
                <fieldset class="textbox">
				
				<label class="name">
                <span>Name</span>
                <input id="name" name="name" value="" type="text" autocomplete="on" placeholder="Name">
                </label>
				
            	<label class="username">
                <span>Email</span>
                <input id="username" name="username" value="" type="text" autocomplete="on" placeholder="Email id">
                </label>
                
                <label class="contact">
                <span>Contact number</span>
                <input id="contact" name="contact" value="" type="tel" placeholder="Contact Number">
                </label>
				
				<label class="college">
                <span>College</span>
                <input id="college" name="college" value="" type="text" placeholder="College">
                </label>
                
				<label class="events">
                <span>Event</span>
                <select name="event">
		</form>
</div>
	
</body>
</html>