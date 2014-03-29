<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <title>Creatyst</title>

	{{ HTML::script('js/jquery.js')}}
	{{ HTML::script('js/main.js')}}
	{{ HTML::style('packages/bootstrap/css/bootstrap.min.css') }}
    {{ HTML::style('css/main.css')}}
	{{ HTML::style('css/selectize.css')}}
	{{ HTML::script('js/selectize.min.js')}}
<script type="text/javascript">
    var root = '{{url("/")}}';
</script>
</head>
  <body>
	
	<div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <ul class="nav"> 
                @if(!Auth::check())
                    <li>{{ HTML::link('register', 'Register') }}</li>  
                    <li>{{ HTML::link('login', 'Login') }}</li>  
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
		
		 {{ $content }}
    </div>
	<form>
	<select id="searchbox" name="q" placeholder="Search,products,categories" class="form-control" style="width:300px;"></select>
	</form>
<script>
  $(document).ready(function(){
      $('#searchbox').selectize();
  });
</script>
	
  </body>
</html>