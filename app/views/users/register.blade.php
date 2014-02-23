{{ Form::open(array('url'=>'users/create', 'class'=>'form-signup')) }}
    <h2 class="form-signup-heading">Please Register</h2>
 
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
 
    {{ Form::text('firstname', null, array('class'=>'input-block-level', 'placeholder'=>'First Name')) }}
    {{ Form::text('city', null, array('class'=>'input-block-level', 'placeholder'=>'City')) }}
    {{ Form::text('email', null, array('class'=>'input-block-level', 'placeholder'=>'Email Address')) }}
	{{ Form::select('talent', array(null=> 'Your Talent','dancer' => 'Dancer', 'singer' => 'Singer', 'musician' => 'Musician', 'singer' => 'Singer', 'photographer' => 'Photographer', 'painter' => 'Painter', 'others' => 'Others'),null,array('class'=>'input-block-level'))}}
    {{ Form::password('password', array('class'=>'input-block-level', 'placeholder'=>'Password')) }}
    {{ Form::password('password_confirmation', array('class'=>'input-block-level', 'placeholder'=>'Confirm Password')) }}
 
    {{ Form::submit('Register', array('class'=>'btn btn-large btn-primary btn-block'))}}
{{ Form::close() }}