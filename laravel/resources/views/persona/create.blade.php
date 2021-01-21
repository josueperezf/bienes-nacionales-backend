{!! Form::open(['route'=>'persona.store','method' => 'post']) !!}
	{!! Form::label('cedula','Cedula') !!}
	{!! Form::text('cedula',null,['maxlength'=>'0','autofocus'=>'autofocus']) !!}
	{!! Form::label('apellidos','Apellidos') !!}
	{!! Form::text('apellidos',null,['maxlength'=>'100']) !!}
	{!! Form::label('nombres','Nombres') !!}
	{!! Form::text('nombres',null,['maxlength'=>'100']) !!}
{!! Form::close() !!}