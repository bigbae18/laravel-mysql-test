@extends('layouts.app')

@section('content')
<h1 class="title-error m-b-md">{{ $title }}</h1>

<div class="links">
@if ($errors->has('email'))
    @foreach($errors->get('email') as $message)
        <p>{{$message}}</p>
    @endforeach
@endif
@if ($errors->has('password'))
    @foreach ($errors->get('password') as $message)
        <p>{{$message}}<p>
    @endforeach
@endif

<a href="{{$requested_url}}">Go Back</a>
</div>
@endsection