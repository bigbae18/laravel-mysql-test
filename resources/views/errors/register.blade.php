@extends('layouts.app')

@section('content')
<h1 class="title-error m-b-md">{{ $title }}</h1>

<div class="links">
@if ($errors->has('name'))
    @foreach($errors->get('name') as $message)
        <p>{{$message}}</p>
    @endforeach
@endif
@if ($errors->has('surname'))
    @foreach ($error->get('surname') as $message)
        <p>{{$message}}<p>
    @endforeach
@endif
@if ($errors->has('email'))
    @foreach ($error->get('email') as $message)
        <p>{{$message}}<p>
    @endforeach
@endif
@if ($errors->has('phone'))
    @foreach ($error->get('phone') as $message)
        <p>{{$message}}<p>
    @endforeach
@endif
@if ($errors->has('password'))
    @foreach ($error->get('password') as $message)
        <p>{{$message}}<p>
    @endforeach
@endif
@if ($errors->has('repeat_password'))
    @foreach ($error->get('repeat_password') as $message)
        <p>{{$message}}<p>
    @endforeach
@endif

<a href="{{$requested_url}}">Go Back</a>
</div>
@endsection