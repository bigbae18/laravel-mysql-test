@extends('layouts.app')

@section('content')
<h1 class="title-error m-b-md">{{ $title }}</h1>

<div class="links">
@if ($errors->has('iban'))
    @foreach($errors->get('iban') as $message)
        <p>{{$message}}</p>
    @endforeach
@endif
@if ($errors->has('identity_document'))
    @foreach ($error->get('identity_document') as $message)
        <p>{{$message}}<p>
    @endforeach
@endif
@if ($errors->has('billing_address'))
    @foreach ($error->get('billing_address') as $message)
        <p>{{$message}}<p>
    @endforeach
@endif
<a href="{{$requested_url}}">Go Back</a>
</div>
@endsection