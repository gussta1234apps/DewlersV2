@extends('layouts.app')
@section('extra_links')
    <!--CSS IMPORT-->
    <link rel="stylesheet" href="{{ asset('resources/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/css/loading.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/jquery-ui/jquery-ui.min.css') }}">

    <!-- BOOTSTRAP CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('resources/css/jquery.fancybox.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/css/custom-fancy.css') }}">
@stop
@section('content')
    <!-- Container -->

    <div id="load-container">
        <div class="loading">
            <div class="obj"></div>
            <div class="obj"></div>
            <div class="obj"></div>
            <div class="obj"></div>
            <div class="obj"></div>
            <div class="obj"></div>
            <div class="obj"></div>
            <div class="obj"></div>
        </div>
    </div>



    <!-- Menu Button -->
    <div class="menu-bar">

        <div class="menu-button-container">
            <button class="menu-button" ><em class="fas fa-bars"></em></button>
        </div>
        <div class="create-dewl-mobile">
            <button class="create-dewl-button-mobile"><div class="circle-plus"><em class="fas fa-plus"></em>&nbsp;Create Dewl</div></button>
        </div>

        <div class="right-top-icon">
            <div class="menu-img-right-icon"></div>
        </div>

        <!-- FANCYBOX MODAL BUTTON -->
        <button class="login100-form-btn" data-fancybox="true" data-animation-duration="700" data-src="#fancyBoxModal" href="javascript:;" id="showFancyBox" style="display:none;">
        </button>

    </div>

    <!-- MENU BOX -->
    <div class="menu-box">

        <button class="hide-menu-button" onclick="toggleMenu();"><em class="fas fa-times"></em></button>
        <div class="menu-img">
            <div class="menu-img-icon"></div>
            <div class="dewl-stats">
                <h5 class="menu-name-label"> {{ Auth::user()->name }}</h5>

                <div class="dewl-winrate center">
                    <div class=winrate-percent style="width: 60%"></div>
                    <h4>60% hype rating</h4>
                </div>

                <h5 class="menu-stacks-label"><strong>{{ $amount  = \Illuminate\Support\Facades\DB::table('internalaccounts')->where('id','=',Auth::user()->id)->first()->balance}}</strong>&nbsp;Stacks</h5>
                <button class="menu-add-stacks center" data-toggle="modal" data-target="#addStacksModal" onclick="toggleMenu();">
                    <em class="fas fa-plus"></em>&nbsp;Add stacks
                </button>
            </div>
        </div>
        <ul class="menu-list">
            <li class="menu-item profile-item" onclick="showHome();">Dashboard</li>
            <li class="menu-item profile-item" onclick="showHistory();" style="color: #CE3250;">Dewling History</li>
            <!--li class="menu-item request-item" onclick="showRequests();" style="color:#08ADD5;">Witness</li-->
            <!--li class="menu-item request-item" onclick="showCourses();">Create Dewl</li-->
            <!--li class="menu-item request-item" onclick="showCourses();">Deposit Stacks</li-->
        </ul>

        <button class="settings">Settings</button>
         <form id="logout-form" action="{{ route('logout') }}" method="POST" >
             <button class="logout"  type="submit">Logout</button>
        @csrf
        </form>
    </div>

    <!-- FRIENDS BOX -->
    <div class="friends-box">
        <button class="hide-friends-button" onclick="toggleFriendBox();"><em class="fas fa-times" style="color: #747174"></em></button>
        <!--div-- class="friends-load">
            <div class="friends-load-img"></div>
        </div-->
        <div class="header-search">
            <input type="text" class="dewler-search-input" placeholder="Dewlers Search">
        </div>


        <!-- FANCYBOX MODAL -->
        <div id="fancyBoxModal" class="animated-modal" style="display:none;">
            <h4>Hype Rating&nbsp;<!--em class="fas fa-user-circle"></em--></h4>
            <br/>
            <div>
                Here is the hype rating information
            </div>
        </div>
        <div class="friends-body">
            <div id="request-notifcation-container">
                <div class="friends-request-notification">
                    <div class="request-notification-circle">
                        <p> @php
                                echo count($pending_f_req);
                            @endphp</p>
                    </div>
                    <p class="request-notification-title">Pending Requests</p>
                </div>
            </div>
            <hr/>
            <div id="dewler-search-container" class="center-load"></div>
            <div id="friends-container" >
                <h5>Your Friends</h5>
                @foreach($challengeds as $friend)
                    <div class="friends-info-card">
                        <button class="friends-dewl-button" onclick="loadPlayerToDewl({{$friend->id}},'{{$friend->username}}')">Create Dewl</button>
                        <button class="friends-remove-button">Remove</button>
                        <p class="friends-info-name">{{$friend->username}}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="request-body">
            <button class="return-to-friends-body"><em class="fas fa-chevron-left"></em>&nbsp;Return</button>
            <h5>Pending Requests</h5>
{{--            <div class="friends-info-card">--}}
{{--                <button class="friends-accept-button">Accept</button>--}}
{{--                <button class="friends-remove-button">Decline</button>--}}
{{--                <p class="friends-info-name">Ariel Zelaya</p>--}}
{{--            </div>--}}
{{--            <div class="friends-info-card">--}}
{{--                <button class="friends-accept-button">Accept</button>--}}
{{--                <button class="friends-remove-button">Decline</button>--}}
{{--                <p class="friends-info-name">Diego Gonzales</p>--}}
{{--            </div>--}}

            @foreach($pending_f_req as $friend)
                <div class="friends-info-card">
                <form action="#" method="get">
                @csrf
                    <button class="friends-accept-button" type="submit" formaction="/acept_friend/{{$friend->sender->id}}">Accept</button>
                    <button class="friends-remove-button" type="submit" formaction="/refuse_friend/{{$friend->sender->id}}">Decline</button>
                    <p class="friends-info-name"> {{$friend->sender->username}}</p>
                </form>
                </div>

{{--                      --}}
{{--                        <div class="btn btn-primary" onclick="accept_request()">Acept</div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-4 fb_btn">--}}
{{--                        <div cla    ss="btn btn-danger" onclick="refuse_request({{$friend->sender->id}})">Decline</div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <script type="application/javascript">--}}

{{--                </script>--}}
            @endforeach
        </div>
        <!--div class="friends-top">
            <h4 class="dewler-search-label">Dewler Seacrh</h4>
            <div class="dewler-search">

                <input type="text" class="dewler-search-input">
                <button class="dewler-search-button"><em class="fas fa-search"></em></button>
            </div>
        </div>
        <div class="friends-request">
            <div class="row" style="margin-left:0;">
                <div class="col">
                    <div class="friends-count-card">
                        <p class="center">120 Friends</p>
                    </div>
                </div>
                <div class="col">
                    <div class="friends-request-count-card">
                        <p class="center">10 Requests</p>
                    </div>
                </div>
            </div>
            <div class="friends-pending-request">
                <table>
                    <thead></thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <div class="friends-results">
            <table>
                <tbody id="results-table" style="overflow-y: scroll;">
                <tr>
                    <td>
                        <div class="card" style="width: 255px">
                            <div class="card-body">
                                <h5 class="card-title text-center">Ariel Zelaya</h5>

                                <center>
                                    <button href="#" class="btn btn-success friend-request-card-button">Dewl</button>
                                    <button href="#" class="btn btn-danger friend-request-card-button">Remove</button>
                                </center>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="card" style="width: 255px">
                            <div class="card-body">
                                <h5 class="card-title text-center">Diego Gonzales</h5>

                                <center>
                                    <button href="#" class="btn btn-success friend-request-card-button">Dewl</button>
                                    <button href="#" class="btn btn-danger friend-request-card-button">Remove</button>
                                </center>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="card" style="width: 255px">
                            <div class="card-body">
                                <h5 class="card-title text-center">Card title</h5>

                                <center>
                                    <button href="#" class="btn btn-success friend-request-card-button">Dewl</button>
                                    <button href="#" class="btn btn-danger friend-request-card-button">Remove</button>
                                </center>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div-->
    </div>

    <button class="friends-button" onclick="toggleFriendBox()"><em class="fas fa-user-friends"></em></button>


    <!-- APP -->
    <div class="app center" id="history">

        <!--Dewling History-->

        <div class="history">
            <button class="create-dewl-button-desktop"><em class="fas fa-plus"></em>&nbsp;Create Dewl</button>
            <div class="app-dewler-data">
                <h5 class="menu-name-label"> {{ Auth::user()->name }}</h5>

                <div class="dewl-winrate center">
                    <div class=winrate-percent style="width: 60%"></div>
                    <h4>60% hype rating</h4>
                </div>

                <h6 CLASS="wins-label">10 WINS</h6>
            </div>



            <div class="table-dewl">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-win" role="tab" aria-controls="nav-home" aria-selected="true" style="color: #08ADD5">All Wins</a>
                        <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-loss" role="tab" aria-controls="nav-profile" aria-selected="false" style="color: #CE3250">All Losses</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-win" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="dewl-h">
                            <table class="table table-borderless">
                                <!--thead style="color: #08ADD5;">
                                <tr>
                                    <th>Opponent</th>
                                    <th>Stacks</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                </--thead-->
                                <tbody>
                                @foreach($r_winner as $win)
                                    <tr>
                                        <td colspan="4">
                                            <div class="card-table-win-dewl">
                                                <div class="short-desc">
                                                    <div class="row ">
                                                        <div class="col-md-4 current-card-column"><strong>{{$win->ctlUser1->username}}</strong></div>
                                                        <div class="col-md-3 current-card-column"><strong>{{$win->pot}}</strong></div>
                                                        <div class="col-md-3 current-card-column"><strong>{{$win->startDate}}</strong></div>
                                                        <div class="col-md-2 current-card-column">
                                                            <button class="win-card-info-button" data-toggle="collapse" href="#win-card-{{$win->id}}" role="button" aria-expanded="false" aria-controls="win-card-{{$win->id}}">
                                                                More info
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="collapse detail" id="win-card-{{$win->id}}">
                                                    <div class="center-mobil txt-blck all-width">
                                                        <h4 class="card-view-title">{{$win->tittle}}</h4>
                                                        <p class="card-view-description">{{$win->Description}}</p>
                                                        <p class="card-view-date">Start Date: {{$win->startDate}}</p>
                                                        <p class="card-view-status">Status: {{$win->duelstatus->description}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-loss" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="dewl-h">
                            <table class="table table-borderless">
                                <!--thead style="color: #CE3250;">
                                <tr>
                                    <th>Opponent</th>
                                    <th>Stacks</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead-->
                                <tbody>
                                @foreach($r_loser as $loss)
                                    <tr>
                                        <td colspan="4">
                                            <div class="card-table-loss-dewl">
                                                <div class="short-desc">
                                                    <div class="row ">
                                                        <div class="col-md-4 current-card-column"><strong>{{$loss->ctlUser1->username}}</strong></div>
                                                        <div class="col-md-3 current-card-column"><strong>{{$win->pot}}</strong></div>
                                                        <div class="col-md-3 current-card-column"><strong>{{$win->startDate}}</strong></div>
                                                        <div class="col-md-2 current-card-column">
                                                            <button class="loss-card-info-button" data-toggle="collapse" href="#loss-card-{{$loss->id}}" role="button" aria-expanded="false" aria-controls="loss-card-{{$loss->id}}">
                                                                More info
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="collapse detail" id="loss-card-{{$loss->id}}">
                                                    <div class="center-mobil txt-blck all-width">
                                                        <h4 class="card-view-title">{{$loss->tittle}}</h4>
                                                        <p class="card-view-description">{{$loss->Description}}</p>
                                                        <p class="card-view-date">Start Date: {{$loss->startDate}}</p>
                                                        <p class="card-view-status">Status: {{$loss->duelstatus->description}}</p>
                                                        <button class="loss-button">Double or Nothing</button>
                                                        <button class="loss-button" data-toggle="modal" data-target="#createwitnessreview{{$loss->id}}">Review</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Review Modal-->
                                    <div class="modal fade" id="createwitnessreview{{$loss->id}}" tabindex="-1" aria-labelledby="create witness review" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color: #23272b; color:white;">
                                                    <h5 class="modal-title" id="createDewlModalLabel">Witness review</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <em class="fas fa-times" style="color: white;"></em>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                   <h1>{{$loss->id}}</h1>
                                                    <!-- Star System -->
                                                    <div class="text-center underline" style="margin-top: 30px; ">
                                                        <input type="radio" class="hidden" name="stars" id="star-null" hidden/>
                                                        <input type="radio" class="hidden" name="stars" value="1" id="star-1" hidden/>
                                                        <input type="radio" class="hidden" name="stars" value="2" id="star-2" hidden/>
                                                        <input type="radio" class="hidden" name="stars" value="3" id="star-3" hidden/>
                                                        <input type="radio" class="hidden" name="stars" value="4" id="star-4" hidden/>
                                                        <input type="radio" class="hidden" name="stars" value="5" id="star-5"  checked  hidden/>   <!-- checked hace que este activo -->
                                                        <section>
                                                                    <h4>Rate the witness</h4>
                                                            <label  for="star-1"> <svg width="10%" id="star1" onclick="ani1()" height="10%" style="fill:#eeeeee;" viewBox="0 0 51 48">
                                                                    <path  d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"/>
                                                                </svg> </label>
                                                            <label  for="star-2"> <svg width="10%" id="star2" onclick="ani2()" height="10%" style="fill:#eeeeee;" viewBox="0 0 51 48">
                                                                    <path d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"/>
                                                                </svg> </label>
                                                            <label  for="star-3"> <svg width="10%" id="star3" onclick="ani3()" height="10%" style="fill:#eeeeee;" viewBox="0 0 51 48">
                                                                    <path d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"/>
                                                                </svg> </label>
                                                            <label  for="star-4"> <svg width="10%" id="star4" onclick="ani4()" height="10%" style="fill:#eeeeee;" viewBox="0 0 51 48">
                                                                    <path d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"/>
                                                                </svg> </label>
                                                            <label  for="star-5"> <svg width="10%" id="star5" onclick="ani5()" height="10%" style="fill:#eeeeee;" viewBox="0 0 51 48">
                                                                    <path d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"/>
                                                                </svg> </label>
                                                            <!-- <label for="star-null"> Clear </label> -->    <!-- Esto es para reset las estrellas -->

                                                        </section>
                                                        <input type="text" value="" name="id" hidden>

                                                        <br>
                                                        <br>

                                                        <div class="text-center">
                                                            <h4>Leave a review</h4>
                                                            <textarea id="txtarea" name="review" class="textareastyle" rows="10" style="margin-top:5px; max-width:90%; width:570px;"required></textarea>
                                                        </div>
                                                        <!-- End Start System -->
                                                    <div class="text-center" style="margin-top: 25px;">
                                                        <button type="submit" class="btn btn-success" value="">SEND</button>
                                                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Review Modal -->

                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="app center" id="home">
        <div class="history">
            <button class="create-dewl-button-desktop"><em class="fas fa-plus"></em>&nbsp;Create Dewl</button>
            <div class="app-dewler-data">
                <h5 class="menu-name-label"> {{ Auth::user()->name }}</h5>

                <div class="dewl-winrate center">
                    <div class=winrate-percent style="width: 60%"></div>
                    <h4>60% hype rating</h4>
                </div>

                <h6 CLASS="wins-label">10 WINS</h6>
            </div>
            <div class="table-dewl" >
                <nav>
                    <div class="nav nav-tabs" id="nav-tab-home" role="tablist">
                        <a class="nav-link active" id="nav-1-tab" data-toggle="tab" href="#nav-current" role="tab" aria-controls="nav-current" aria-selected="true" style="color: #08ADD5">Current</a>
                        <a class="nav-link" id="nav-3-tab" data-toggle="tab" href="#nav-witness" role="tab" aria-controls="nav-witness" aria-selected="false" style="color: #1c1a1a">Witness</a>
                        <a class="nav-link" id="nav-2-tab" data-toggle="tab" href="#nav-transaction" role="tab" aria-controls="nav-transaction" aria-selected="false" style="color: #CE3250">Transactions</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent2">
                    <div class="tab-pane fade show active" id="nav-current" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="dewl-h">
                            <table class="table table-borderless">
                                <thead style="color: #08ADD5;">
                                <tr>
                                    <th colspan="4 center">Current Dewls</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($duels as $du)
                                    <tr>
                                        <td colspan="4">
                                            <div  @if($du->ctl_user_id_witness) class="card-table-with-witness" @else class="card-table-without-witness" @endif>
                                                <div class="short-desc">
                                                    <div class="row"  data-toggle="collapse" href="#card-current-{{$du->id}}" role="button" aria-expanded="false" aria-controls="card-current-{{$du->id}}">
                                                        <div class="col-2 current-card-column"><h4 class="vs-text-without-witness">VS</h4></div>
                                                        <div class="col-4 current-card-column">
                                                            <strong>
                                                                @if($du->ctl_user_id_challenger == @Auth::id())
                                                                    {{$du->ctlUser1->username}}
                                                                @else
                                                                    {{$du->ctlUser0->username}}
                                                                @endif
                                                            </strong>
                                                        </div>
                                                        <div class="col-1 current-card-column"><em class="fas fa-clock"></em></div>
                                                        <div class="col-4 current-card-column"><strong>{{$du->pot}} Stacks</strong></div>
                                                    </div>
                                                </div>
{{--                                               Variations stars here--}}

                                                @if($du->ctl_user_id_challenged == Auth::user()->id and $du->duelstate==1)
{{--                                                    If your the challenged and havent accepted the  dewl--}}

                                                    <div class="collapse detail" id="card-current-{{$du->id}}">
                                                        <div class="center-mobil txt-blck all-width">
                                                            <h4 class="card-view-title">Please accept or decline this Dewl</h4>
                                                            <div class="card-view-info center-mobil">
                                                                <br>
                                                                <form action="#" method="post">
                                                                    @csrf
                                                                    <input type="text" value="{{$du->id}}" name="id" hidden>
                                                                <div class="row col-6 offset-3">
                                                                    <div class="col">
                                                                        <button class="first-player-button" id="acept{{$du->id}}" type="submit" formaction="/acept_duel">Accept</button>
                                                                    </div>
                                                                    <div class="col">
                                                                        <button class="second-player-button" id="refuse{{$du->id}}" type="submit" formaction="/delete_duel">Decline</button>
                                                                    </div>
                                                                </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class="col-1 current-card-column"><em class="fas fa-clock"></em></div>
                                                        <div class="col-4 current-card-column"><strong>{{$du->pot}} Stacks</strong></div>
                                                    </div>

                                                @elseif($du->ctl_user_id_challenged==Auth::user()->id and $du->duelstate==2)
{{--                                                    if your the challenged and you and the witness havent accepted yet--}}
                                                    <div class="collapse detail" id="card-current-{{$du->id}}">
                                                        <div class="center-mobil txt-blck all-width">
                                                            <h4 class="card-view-title">You have been invited to participate on a Dewl.</h4>
                                                            <div class="card-view-info center-mobil">
                                                                <br>
                                                                <form action="#" method="post">
                                                                    @csrf
                                                                    <input type="text" value="{{$du->id}}" name="id" hidden>
                                                                <div class="row col-6 offset-3">
                                                                    <div class="col center-mobil">
                                                                        <button class="first-player-button" id="acept{{$du->id}}" type="submit" formaction="/acept_duel">Accept</button>
                                                                    </div>
                                                                    <div class="col center-mobil">
                                                                        <button class="second-player-button" id="refuse{{$du->id}}" type="submit" formaction="/delete_duel">Decline</button>
                                                                    </div>
                                                                </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($du->ctl_user_id_winner==Auth::user()->id and $du->duelstate==7)
{{--                                                    if your are the winner of te first dewl and looser challenge you to double or nothing--}}

                                                    <div class="collapse detail" id="card-current-{{$du->id}}">
                                                        <div class="center-mobil txt-blck all-width">
                                                            <h4 class="card-view-title">You have been invited to continue Dewling in a Double or Nothing.</h4>
                                                            <div class="card-view-info center-mobil">
                                                                <br>
                                                                <form action="#" method="post">
                                                                    @csrf
                                                                    <input type="text" value="{{$du->id}}" name="id" hidden>
                                                                <div class="row col-8 offset-2">
                                                                    <div class="col center-mobil">
                                                                        <button class="first-player-button" id="acept{{$du->id}}" type="submit" formaction="/acept_duel">Accept</button>
                                                                    </div>
                                                                    <div class="col center-mobil">
                                                                        <button class="second-player-button" id="refuse{{$du->id}}" type="submit" formaction="/delete_duel">Decline</button>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($du->ctl_user_id_winner==Auth::user()->id and $du->duelstate==10)
                                                    <div class="collapse detail" id="card-current-{{$du->id}}">
                                                        <div class="center-mobil txt-blck all-width">
                                                            <h4 class="card-view-title">You have been invited to continue Dewling in a Double or Nothing.</h4>
                                                            <br>
                                                            <form action="#" method="post" class="card-view-info center-mobil">
                                                                    @csrf
                                                                    <input type="text" value="{{$du->id}}" name="id" hidden>
                                                                <div class="row col-6 offset-3">
                                                                    <div class="col center-mobil">
                                                                        <button class="first-player-button" id="acept{{$du->id}}" type="submit" formaction="/acept_duel">Accept</button>
                                                                    </div>
                                                                    <div class="col center-mobil">
                                                                        <button class="second-player-button" id="refuse{{$du->id}}" type="submit" formaction="/delete_duel">Decline</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="collapse detail" id="card-current-{{$du->id}}">
                                                        <div class="center-mobil txt-blck all-width">
                                                            <h4 class="card-view-title">{{$du->tittle}}</h4>
                                                            <p class="card-view-description">{{$du->Description}}</p>
                                                            <p class="card-view-date">Start Date: {{$du->startDate}}</p>
                                                            <p class="card-view-status">Status: {{$du->duelstatus->description}}</p>
                                                            @if($du->ctl_user_id_witness or $du->ctl_user_id_challenged==Auth::user()->id)
{{--                                                            If your the challenger or challenged--}}
                                                                @if($du->ctl_user_id_witness)
{{--                                                                    if the dewl has witness--}}
                                                                <div class="card-view-info  center-mobil">
                                                                    <div class="row">
                                                                        <div class="col-6 offset-3">
                                                                            <div class="row">
                                                                                <div class="col center-mobil">
                                                                                    <h5 class="witness-info-title">Witness</h5>
                                                                                    <p class="witness-info-text">{{$du->ctlUser2->username}}</p>
                                                                                </div>
                                                                                <div class="col center-mobil">
                                                                                    <h5 class="witness-info-title">Comission</h5>
                                                                                    <p class="witness-info-text">{{$du->witness_comision}}%</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                {{--                                                              End      if the dewl has witness--}}
                                                            @elseif($du->ctl_user_id_challenger==Auth::user()->id and $du->duelstate==4 or $du->duelstate==9)
{{--                                                            if your the challenger or challenged and the dewl is running shows --}}
                                                                <form action="#" method="GET" class="card-view-info center-mobil">
                                                                    @csrf
                                                                    <h4 class="card-view-cw-title">Choose Winner</h4>
                                                                    <div class="row col-6 offset-3">
                                                                        <div class="col center-mobil">
                                                                            <button class="first-player-button" type="submit" formaction="/update_balance/{{$du->id}}/{{$du->ctl_user_id_challenged}}/{{$du->ctl_user_id_challenger}}">{{$du->ctlUser1->username}}</button>
                                                                        </div>
                                                                        <div class="col center-mobil">
                                                                            <button class="second-player-button" type="submit" formaction="/update_balance/{{$du->id}}/{{$du->ctl_user_id_challenger}}/{{$du->ctl_user_id_challenged}}" >{{$du->ctlUser0->username}}</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
{{--                                                Variations ends here--}}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-transaction" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="dewl-h">
                            <table class="table table-borderless">
                                <thead style="color: #08ADD5;">
                                <tr>
                                    <th colspan="4 center" style="color: #CE3250;">Transaction History</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="4">
                                        <div class="card-table">
                                            <em class="top-transaction-icon fas fa-credit-card"></em>
                                            <div class="short-desc">
                                                <div class="row"  data-toggle="collapse" href="#transaction-row1" role="button" aria-expanded="false" aria-controls="transaction-row1">
                                                    <div class="col-md-4 current-card-column"><strong>20 August 2020</strong></div>
                                                    <div class="col-md-4 current-card-column">Stack purchase</div>
                                                    <div class="col-md-4 current-card-column"><strong>+200 Stacks</strong></div>
                                                </div>
                                            </div>
                                            <div class="collapse detail" id="transaction-row1">
                                                <div class="detail-data">
                                                    Deposit Stacks <strong>200</strong>
                                                    <br>
                                                    Paid: <strong>$10</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="4">
                                        <div class="card-table">
                                            <div class="short-desc">

                                                <em class="top-transaction-icon fas fa-gamepad"></em>
                                                <div class="row"  data-toggle="collapse" href="#transaction-row2" role="button" aria-expanded="false" aria-controls="collapseExample2">
                                                    <div class="col-md-4 current-card-column"><strong>21 August 2020</strong></div>
                                                    <div class="col-md-4 current-card-column">Dewl Victory</div>
                                                    <div class="col-md-4 current-card-column"><strong>+40 Stacks</strong></div>
                                                </div>
                                            </div>
                                            <div class="collapse detail" id="transaction-row2">
                                                <div class="detail-data">
                                                    Stacks earned: <strong>40</strong>
                                                    <br>
                                                    You won vs: <strong>ArielZelaya123</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-witness" role="tabpanel" aria-labelledby="nav-witness-tab">
                        <div class="dewl-h">
                            <table class="table table-borderless">
                                <thead style="color: #08ADD5;">
                                <tr>
                                    <th colspan="4 center" style="color:#000"><strong>Serving as Witness</strong></th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($dash_witness as $witness)
                                <tr>
                                    <td colspan="4">
                                        <div class="card-table">
                                            <div class="short-desc">
                                                <div class="row"  data-toggle="collapse" href="#witness-collapse-{{$witness->id}}" role="button" aria-expanded="false" aria-controls="witness-collapse-{{$witness->id}}">
                                                    <div class="col-md-5 current-card-column"><strong>{{$witness->ctlUser0->username}} VS {{$witness->ctlUser1->username}}</strong></div>
                                                    <div class="col-md-3 col-7 current-card-column"><strong>{{$witness->pot}} stacks</strong></div>
                                                    <div class="col-md-2 col-3 current-card-column"><strong>DATA</strong></div>
                                                    <div class="col-md-1 col-2 current-card-column"><i class="fas fa-exclamation notification-icon"></i></div>
                                                </div>
                                            </div>
                                            <div class="collapse detail" id="witness-collapse-{{$witness->id}}">
                                                <div class="center-mobil text-center chwin-content">
                                @if($witness->duelstate==2 or $witness->duelstate==3 or $witness->duelstate==10 or $witness->duelstate==11)
                                <h4 class="card-view-title" style="color:black;font-size:18px;">
                                You have been invited as a Witness to this Dewl. <br>
                                Please select your Witness Percentage.
                                </h4>
                                <form action="#" method="post" class="choose-winner">
                                    @csrf
                                    @if($witness->ctlUser1->review_avg<2.5 )
                                    <p style="border: 0px solid #761b18; color: #761b18;border-radius:5px;margin:5px;font-size:15px;font-weight:800;padding:3px;">
                                        {{$witness->ctlUser1->username}} is a sore loser
                                    </p>
                                    @elseif($witness->ctlUser0->review_avg<2.5)
                                    <p style="border: 0px solid #761b18; color: #761b18;border-radius:5px;margin:5px;font-size:15px;font-weight:800;padding:3px;">
                                        {{$witness->ctlUser0->username}} is a sore loser
                                    </p>
                                    @endif

                                    <div class="row ">
                                        {{--<div class="row text-center">--}}
                                        <div class=" col-lg-12 ">
                                            <input type="number" name="percentage" min="1" max="7" id="input{{$witness->id}}">
                                            <input type="text" value="{{$witness->id}}" name="id" hidden>
                                        </div>
                                    </div>
                                    <div class="row text-center">
                                        {{--<div class="row text-center">--}}
                                        <div class="col-lg-6">
                                            <button class="btn-primary btn-primary btn btn{{$witness->id}}" style="background-color: #00B6E3;" id="acept{{$witness->id}}" type="submit" formaction="/witn_validate">Accept</button>
                                        </div>
                                        <div class="col-lg-6">
                                            <button class="btn btn-danger" style="background-color: #D5130B" id="refuse{{$witness->id}}" type="submit" formaction="/nowith">Decline</button>

                                        </div>
                                        {{-- </div>--}}
                                    </div>
                                </form>
                                @else
                                    @if($witness->duelstate==4 or $witness->duelstate==9)
                                    <form action="#" method="post" class="choose-winner">
                                        <h4>Choose the winner</h4>
                                        <div class="col-md-8 offset-md-2 col-12">
                                            <div class="row choose-winner-row">
                                                <div class="col-md-5 col-5 witness-player-selector">
                                                    <button type="button" class="btn btn-primary player-1">{{$witness->ctlUser0->username}}</button>
                                                </div>
                                                <div class="col-md-2 col-2 d-flex align-items-center justify-content-center">
                                                    <h4 cl>VS</h4>
                                                </div>
                                                <div class="col-md-5 col-2 witness-player-selector">
                                                    <button type="button" class="btn btn-primary player-2">{{$witness->ctlUser1->username}}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    @endif
                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                                    <!--div class="choose-winner ">
                                                    <h4>Choose the winner</h4>
                                                        <div class="col-md-8 offset-md-2 col-12">
                                                            <div class="row choose-winner-row">
                                                                <div class="col-md-5 col-5 witness-player-selector">
                                                                    <button type="button"
                                                                            class="btn btn-primary player-1">{{$witness->ctlUser0->username}}</button>
                                                                </div>
                                                                <div
                                                                    class="col-md-2 col-2 d-flex align-items-center justify-content-center">
                                                                    <h4 cl>VS</h4>
                                                                </div>
                                                                <div class="col-md-5 col-2 witness-player-selector">
                                                                    <button type="button"
                                                                            class="btn btn-primary player-2">{{$witness->ctlUser1->username}}</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="r-u-sure ">
                                                        <h4>Confirm Alex Won the Dewl?</h4>
                                                        <div class="col-md-8 offset-md-2 col-12">
                                                            <div class="row justify-content-center">
                                                                <div class="col-md-6 col-6"><button type="button" class="btn btn-success">Yes</button></div>
                                                                <div class="col-md-6 col-6"> <button type="button" class="btn btn-danger">No</button></div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr-->
                                @endforeach


                                <!--tr>
                                    <td colspan="4">
                                        <div class="card-table">
                                            <div class="short-desc">
                                                <div class="row"  data-toggle="collapse" href="#witness-collapse-2" role="button" aria-expanded="false" aria-controls="witness-collapse-2">
                                                    <div class="col-md-5 current-card-column"><strong>Diego VS Gustavo</strong></div>
                                                    <div class="col-md-3 col-7 current-card-column"><strong>4500 stacks</strong></div>
                                                    <div class="col-md-2 col-3 current-card-column"><strong>DATA</strong></div>
                                                    <div class="col-md-1 col-2 current-card-column"><i class="fas fa-exclamation notification-icon"></i></div>
                                                </div>
                                            </div>
                                            <div class="collapse detail" id="witness-collapse-2">
                                                <div class="center-mobil text-center chwin-content">
                                                    <div class="choose-winner ">
                                                        <h4>Choose the winner</h4>
                                                        <div class="col-md-8 offset-md-2 col-12">
                                                            <div class="row choose-winner-row">
                                                                <div class="col-md-5 col-5 witness-player-selector">
                                                                    <button type="button"
                                                                            class="btn btn-primary player-1">Diego</button>
                                                                </div>
                                                                <div
                                                                    class="col-md-2 col-2 d-flex align-items-center justify-content-center">
                                                                    <h4 cl>VS</h4>
                                                                </div>
                                                                <div class="col-md-5 col-2 witness-player-selector">
                                                                    <button type="button"
                                                                            class="btn btn-primary player-2">Gustavo</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="r-u-sure ">
                                                        <h4>Confirm Gustavo Won the Dewl?</h4>
                                                        <div class="col-md-8 offset-md-2 col-12">
                                                            <div class="row justify-content-center">
                                                                <div class="col-md-6 col-6"><button type="button" class="btn btn-success">Yes</button></div>
                                                                <div class="col-md-6 col-6"> <button type="button" class="btn btn-danger">No</button></div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr-->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- MODALS -->
        <!-- addStacksModal -->
        <div class="modal fade" id="addStacksModal" tabindex="-1" aria-labelledby="addStacksModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="">
                        <div class="modal-header" style="background-color: #23272b; color:white;">
                            <h5 class="modal-title" id="addStacksModalLabel">Add Stacks</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <em class="fas fa-times" style="color: white;"></em>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h5 class="text-center">Enter Stack Amount</h5>
                            <p class="text-center" style="font-size: 14px;font-weight: 500;">$1 = 20 Stacks</p>
                            <input type="text" class="form-control">
                            <br>
                            <h6 class="text-center">Quick add</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <button class="form-control btn btn-primary" style="margin-bottom: 5px">$10</button>
                                </div>
                                <div class="col-md-4">
                                    <button class="form-control btn btn-primary" style="margin-bottom: 5px">$20</button>
                                </div>
                                <div class="col-md-4">
                                    <button class="form-control btn btn-primary" style="margin-bottom: 5px">$25</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <button class="form-control btn btn-primary" style="margin-bottom: 5px">$30</button>
                                </div>
                                <div class="col-md-4">
                                    <button class="form-control btn btn-primary" style="margin-bottom: 5px">$50</button>
                                </div>
                                <div class="col-md-4">
                                    <button class="form-control btn btn-primary" style="margin-bottom: 5px">$100</button>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="button" class="btn btn-success" value="Confirm">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- CREATE DEWL MODAL -->
        <button id="createDewlModalButton" style="display:none;" data-toggle="modal" data-target="#createDewlModal"></button>
        <!-- addStacksModal -->

    </div>
    <div class="modal fade" id="createDewlModal" tabindex="-1" aria-labelledby="addStacksModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/saveduel" method="post" onsubmit="return createDewlValidations()">
                @csrf
                    <div class="modal-header" style="background-color: #23272b; color:white;">
                        <h5 class="modal-title" id="createDewlModalLabel">Create Dewl</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <em class="fas fa-times" style="color: white;"></em>
                        </button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" id="playerID">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="tittle" autocomplete="off" aria-describedby="xsxs" placeholder="Enter title">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Description</label>
                            <textarea name="description" id="descriptio" class="form-control" cols="30" rows="3" placeholder="Enter a description" maxlength="140" required=""></textarea>
                        </div>
                        <label for="exampleInputEmail1">Stacks</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">$</span>
                            </div>
                            <input type="number" id="pot" name="pot" class="form-control" placeholder="10.00" aria-label="pot" aria-describedby="pot" required="" min="10">
                        </div>
                        <small id="emailHelp" class="form-text text-muted">10% of this amount goes to Dewlers</small>
                        <div class="form-group">
                            <label for="exampleInputEmail1" style="margin-top: 10px;">VS</label>
                            <input type="text" class="form-control" autocomplete="off" list="players" onchange="prepareToCreateDewl();" id="playerInput" aria-describedby="challenger" placeholder="Enter Dewler's Name">
                            <datalist id="players">
                                @foreach($challengeds as $friend)
                                    <option value="{{$friend->username}}" data-id="{{$friend->id}}">{{$friend->username}}</option>
                                @endforeach
                            </datalist>

                            <input type="hidden" name="challendged" id="challendged">
                        </div>
                        <!-- Start Select witness -->
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck1" data-toggle="collapse" name="witness_validate" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <label class="custom-control-label" for="customCheck1">Select Witness</label>
                        </div>
                        <div class="collapse" id="collapseExample">
                            <div class="form-group">
                                <label for="exampleInputEmail1" style="margin-top: 10px;">Witness</label>
                                <input type="text" class="form-control" autocomplete="off" list="witnessList" id="witnessInput" onchange="prepareWitnessToCreateDewl();" aria-describedby="challenger" placeholder="Enter Witness' Name">
                                <datalist id="witnessList" >
                                    @foreach($challengeds as $friend)
                                        <option value="{{$friend->username}}" data-id="{{$friend->id}}">{{$friend->username}}</option>
                                    @endforeach
                                </datalist>
                                <input type="hidden" name="witness" id="witness">
                            </div>
                        </div>
                        <!-- End Select witness -->
                        <div class="form-group" style="margin-bottom: 0px !important;">
                            <label for="exampleInputEmail1" style="margin-top:10px;">Schedule Dewl</label>
                            <input type="text" class="form-control" name="startdate" id="datepicker" aria-describedby="emailHelp" readonly placeholder="Select date">
                        </div>
                        <small id="emailHelp" class="form-text text-muted">Dewls expire after 24 hours of the scheduled date.</small>
                        <div class="text-center" style="margin-top: 25px;">
                            <input type="submit" class="btn btn-success" value="DEWL"></button>
                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="button" class="btn btn-success" value="Confirm">
                    </div> -->

                </form>
            </div>
        </div>
    </div>






    <!-- JS IMPORT -->
<script src="{{ asset('resources/js/all.js') }}"></script>
<script src="{{ asset('resources/js/jquery.js') }}"></script>
<script src="{{ asset('resources/js/tilt.jquery.min.js') }}"></script>
<script src="{{ asset('resources/js/main.js') }}"></script>
<script src="{{ asset('resources/js/load.js') }}"></script>
<script src="{{ asset('resources/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('resources/js/jquery.fancybox.js') }}"></script>
<script>
    $( "#datepicker" ).datepicker({dateFormat: "yy-mm-dd",minDate:0});

</script>



<!-- JS, Popper.js, and jQuery -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
@endsection
