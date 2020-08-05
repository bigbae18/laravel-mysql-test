@extends('layouts.app')

@section('content')
<h1 class="title-error m-b-md">{{ $title }}</h1>

<div class="links">
<p>{{$message}}</p>
<a href={{$requested_url}}>Go Back</a>
</div>
@endsection