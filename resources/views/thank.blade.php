
@extends('layouts.app')
@section('extra_links')

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

@stop

@section('content')
<div class="jumbotron text-center">
    <h1 class="display-3">Thank You!</h1>
    <p class="lead">Thanks for dewl with us we hope see you again. LETS DEWL!</p>
    <hr>
    <p>
        Having trouble? <a href="">Contact us</a>
    </p>
    <p class="lead">
        <a class="btn btn-primary btn-sm" href="/dashboard" role="button">Continue to homepage</a>
    </p>
</div>
@endsection
