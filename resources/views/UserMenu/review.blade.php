@extends('layouts.app')
@section('extra_links')

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

@stop

@section('content')
    <div class="container text-center">
        <div class="row">

    <div class="col-lg-12 duelwitness text-center">
        <div class="card ">
            <div class="card-header">Review your Dewl and Witness</div>
            <div class="card-body">



                <form action="/public/send_rev" method="post" id="witnees_review{{$id}}">
                    @csrf

                    <div class="container">
                        <br>
                        <div class="container">

                            <!-- End Input with Masking -->
                            <h3 class="text-center sans" style="color: #333333;font-weight:300; font-size: 22px; padding-bottom:5px; ">Leave us a review :</h3>

                            <!-- Star System -->
                            <div class="text-center underline" style="margin-top: 30px; ">
                                <input type="radio" class="hidden" name="stars" id="star-null" hidden/>
                                <input type="radio" class="hidden" name="stars" value="1" id="star-1" hidden/>
                                <input type="radio" class="hidden" name="stars" value="2" id="star-2" hidden/>
                                <input type="radio" class="hidden" name="stars" value="3" id="star-3" hidden/>
                                <input type="radio" class="hidden" name="stars" value="4" id="star-4" hidden/>
                                <input type="radio" class="hidden" name="stars" value="5" id="star-5"  checked  hidden/>   <!-- checked hace que este activo -->
                                <section>

                                    <label for="star-1"> <svg width="10%" id="star1" onclick="ani1()" height="10%" style="fill:#eeeeee;" viewBox="0 0 51 48">
                                            <path  d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"/>
                                        </svg> </label>
                                    <label for="star-2"> <svg width="10%" id="star2" onclick="ani2()" height="10%" style="fill:#eeeeee;" viewBox="0 0 51 48">
                                            <path d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"/>
                                        </svg> </label>
                                    <label for="star-3"> <svg width="10%" id="star3" onclick="ani3()" height="10%" style="fill:#eeeeee;" viewBox="0 0 51 48">
                                            <path d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"/>
                                        </svg> </label>
                                    <label for="star-4"> <svg width="10%" id="star4" onclick="ani4()" height="10%" style="fill:#eeeeee;" viewBox="0 0 51 48">
                                            <path d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"/>
                                        </svg> </label>
                                    <label for="star-5"> <svg width="10%" id="star5" onclick="ani5()" height="10%" style="fill:#eeeeee;" viewBox="0 0 51 48">
                                            <path d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"/>
                                        </svg> </label>
                                    <!-- <label for="star-null"> Clear </label> -->    <!-- Esto es para reset las estrellas -->

                                </section>
                                <!-- End Start System -->

                                <input type="text" value="{{$id}}" name="id" hidden>

                                <br>
                                <br>

                                <div class="text-center">
                                    <textarea id="txtarea" name="review" class="textareastyle" rows="10" style="margin-top:5px; max-width:50%; width:570px;"required></textarea>
                                </div>

                                <br>
                                <br>

                                <p class="text-center" >

                                    <button  id="two"class="button1 text-center btn btn-primary">Send</button>
                                </p>

                            </div>

                        </div>
                        <br>
{{--                        <input type="text" value="" name="id" hidden>--}}


                    </div>



                </form>

            </div>

        </div>
    </div>
        </div>
    </div>

@endsection
