@extends('layouts.app')

@section('content')
<h1 class="title-error m-b-md">{{ $title }}</h1>

<div class="links">
<p>{{$errors}}</p>
<a href={{$requested_url}}>Go Back</a>
</div>
@endsection