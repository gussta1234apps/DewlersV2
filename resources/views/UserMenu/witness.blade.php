@extends('layouts.app')
@section('content')

    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>

    <!--
        RTL version
    -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.rtl.min.css"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.rtl.min.css"/>
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.rtl.min.css"/>
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.rtl.min.css"/>

    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="container witness-div">
                <div  class="row">
                    <div class="col">
                        <a href="{{ url('/dashboard') }}">
                            {{-- <button type="button" class="btn btn-outline-secondary">Go Back</button> --}}
                            {{ Html::image('img/left-1.svg', 'back', array('style' => 'max-width: 40px; margin:auto; margin-top:15px;color:#6c757d','class'=>'arrow-back')) }}
                            </a>
                    </div>
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col text-right">
                    </div>
                </div>
            </div>


{{--            DUelos donde se es witness--}}
            @foreach($duels as $du)
                @if($du->status==1)
                <div class="col-md-8 duelwitness">
                    <div class="card">
                        <div class="card-header">{{$du->tittle}}</div>
                        <div class="card-body">
                            <form action="#" method="post">
                                @csrf
                                <div class="container">
                                    <div class="row">
                                        <div class="col"><h4>${{$du->pot}}</h4> </div>

                                    </div>
                                    <div class="col"><h5> Select a winner</h5> </div>
                                    <div class="radio-group">
                                        <div class="row">
                                            <div  class="col-md-5 option{{$du->id}}  option challenger"   id="challenger{{$du->id}}"   >
                                                {{ Html::image('img/avatar.svg', 'challenger', array('style' => 'max-width: 40px; margin:auto; margin-top:15px;')) }}
                                                <h5 >{{$du->ctlUser0->username}}</h5>
                                            </div>
                                            <div class="col-md-2"><img src="https://img.icons8.com/ios/50/000000/head-to-head.png" class="vslogo" id="vslogo" ></div>
                                            <div class="col-md-5 option2{{$du->id}} option challenged" id="challenged{{$du->id}}"  >

                                                {{ Html::image('img/avatar.svg', 'challenged', array('style' => 'max-width: 40px; margin:auto; margin-top:15px;')) }}

                                                <h5 class="card-title">{{$du->ctlUser1->username}}</h5>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="collapseExample" class="col collapser{{$du->id}} collapse" >
                                        <a class="btn btn-primary" onclick="ajaxwinner{{$du->id}}()" role="button">Winner</a>
                                    </div>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
                @endif

            @endforeach

            </div>
@foreach($duels as $du)
        <script type="application/javascript">
            $(document).ready(
                function()
                {
                    $(".option{{$du->id}}").click(
                        function(event)
                        {
                            $('#challenger{{$du->id}}').toggleClass("active");

                            var element = document.getElementById("collapseExample");
                            if($("#challenger{{$du->id}}").hasClass("active") || $("#challenged{{$du->id}}").hasClass("active")){
                                $(".collapser{{$du->id}}").collapse('show');
                            }
                            else{
                                $(".collapser{{$du->id}}").collapse('hide');
                            }
                            $('#challenger{{$du->id}}').siblings().removeClass("active");
                        }
                    );
                    $(".option2{{$du->id}}").click(
                        function(event)
                        {
                            $('#challenged{{$du->id}}').toggleClass("active");

                            var element = document.getElementById("collapseExample");
                            if($("#challenger{{$du->id}}").hasClass("active") || $("#challenged{{$du->id}}").hasClass("active")){
                                $(".collapser{{$du->id}}").collapse('show');
                            }
                            else{
                                $(".collapser{{$du->id}}").collapse('hide');
                            }
                            $('#challenged{{$du->id}}').siblings().removeClass("active");
                        }
                    );
                });

            // ESPACIO PARA AJAX
            function ajaxwinner{{$du->id}}(){
                console.log("hola"+{{$du->id}});
                if($("#challenger{{$du->id}}").hasClass("active")){
                    console.log('Gano el retador');
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {


                        }
                    };
                    xhttp.open("GET", "/public/update_balance/{{$du->id}}/{{$du->ctl_user_id_challenger}}/{{$du->ctl_user_id_challenged}}", true);
                    xhttp.send();
                    

                    setTimeout(function(){ location.reload(); }, 1000);
                }
                else{
                    console.log('Gano el retado');
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {

                        }
                    };
                    xhttp.open("GET", "/public/update_balance/{{$du->id}}/{{$du->ctl_user_id_challenged}}/{{$du->ctl_user_id_challenger}}", true);
                    xhttp.send();
                    
                    setTimeout(function(){ location.reload(); }, 1000);

                }
            }
        </script>
        @endforeach
            {{--         FIN de DUelos donde se es witness--}}
        </div>
</div>
@endsection
