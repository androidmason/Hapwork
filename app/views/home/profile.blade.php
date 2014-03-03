
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <title>Creatyst</title>
	{{ HTML::style('packages/bootstrap/css/bootstrap.min.css') }}
    {{ HTML::style('css/main.css')}}
	{{ HTML::style('css/basic.css') }}
	{{ HTML::style('css/slider.css') }}
	<script src="http://code.jquery.com/jquery-1.8.2.min.js" type="text/javascript"></script>
	{{ HTML::script('js/jquery.carouFredSel-6.0.4-packed.js')}}
	<script type="text/javascript">
			$(function() {

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




<h1>{{ $creatyst->firstname }} </h1>

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
					<img src="{{ asset ($files[$x]) }}" alt="fruit1" width="500" height="400" />
					<span>Apple</span>
		</div>
		@endfor
		
		

	</div>
</div>

{{ Form::open(array( 'url' => '/multiupload','files' => true  )) }}
{{ Form::file('file',array('multiple'=>true))}}
{{ Form::hidden('folder', $creatyst->username) }}
{{ Form::submit('Upload To Gallery') }}
{{ Form::close() }}



 </div>
	
</body>
