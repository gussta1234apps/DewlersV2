@extends('layouts.app')
@section('extra_links')
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="{{ asset('js/scripts.js') }}" type="application/javascript"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous" defer></script>

@stop

@section('content')

    <div class="container-fluid">

       <div class="row">

            <div class="col-sm-12 col-md-4  offset-md-4 text-center">

                <p>Search a friend:</p>
                <form action="/public/search_person" method="POST">
                    @csrf
                <input type="text" name="user" id="search_user" class="form-control">
                    <br>
                    <button class="btn btn-dark text-center" type="submit">Search</button>
                </form>

            </div>
        </div>

        <div class="row" style="margin-top: 50px">
            <div class="col-sm-12 col-md-6">
                <div class=" collapse-pending-dewl" id="test1" >
                    <div class="card card-body friend_container">
                        <h4 class="text-center">Friend Requests</h4>
                        <hr>
                        @foreach($pending_f_req as $friend)
                        <div class="friend_notify row">
                            <div class="col-md-4">
                                <p style="margin-bottom: 0; margin-top: 7px">
                                    {{$friend->sender->username}}
                                </p>
                            </div>
                            <div class="col-md-4 fb_btn">
                                <div class="btn btn-primary" onclick="accept_request({{$friend->sender->id}})">Acept</div>
                            </div>
                            <div class="col-md-4 fb_btn">
                                <div class="btn btn-danger" onclick="refuse_request({{$friend->sender->id}})">Decline</div>
                            </div>
                        </div>
                        <script type="application/javascript">

                        </script>
                            @endforeach
                    </div>
                </div>

            </div>

            <div class="col-sm-12 col-md-6">

                <div class=" collapse-pending-dewl" id="test1" >
                    <div class="card card-body friend_container">
                        <h4 class="text-center">Friends</h4>
                        <hr>
                        @foreach($friends as $fri)

                        <div class="friend_notify row">

                            <div class="col-sm-12 col-lg-6 offset-lg-3 text-center">{{$fri->username}}</div>
                        </div>
                        <script type="application/javascript">

                        </script>

                            @endforeach

                    </div>
                </div>

            </div>

        </div>






    </div>

@endsection
