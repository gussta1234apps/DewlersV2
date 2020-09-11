@extends('layouts.app')
@section('extra_links')

<script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js" defer ></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js" defer></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js" defer></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js" defer></script>



@stop
@section('content')




    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-md-12">
                   {{--                AQUI EL MENU--}}
            <div style="margin-bottom:70px;" class="container">
                <div  class="row">
                    <div class="col text-left">
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

            <table id="mytable" class="display responsive nowrap" style="width:100%; ">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Challenged</th>
                    <th>Stacks</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Winner</th>
                    <th hidden>id</th>
                </tr>
                </thead>
                <tbody>
                            @foreach($duels as $du)
                                @if($du->ctl_user_id_challenged == Auth::user()->id)                                                     {{--// si el usuario retado es igual al logueado--}}

                                    @if($du->ctl_user_id_winner != Auth::user()->id and $du->ctl_user_id_winner!=null)                                                     {{--si el ganador es diferente al logueado (permitira el don)--}}

                                        <tr id="acept{{$du->id}}" class="fenix_duel" style="background-color: #2a9055" >                  {{--//clase fenix_duel permite al logueado crear el doble o nada--}}

                                    @elseif($du->ctl_user_id_winner == Auth::user()->id and $du->duelstate!=5)                              {{--// si el ganador es igual al logueado pero no se ha solcitado el doble o nada--}}

                                        <tr id="acept{{$du->id}}">                                                                          {{--//coloca solo este id--}}

                                    @elseif($du->ctl_user_id_winner == Auth::user()->id and $du->duelstate==5)                              {{-- // si el ganador es el logueado (permitira aceptar el don)--}}

                                         <tr id="acept{{$du->id}}" class="don_challenged" style="background-color: #ffd04b" >               {{--// clase don challenged (permite aceptar el don)--}}

                                    @endif
                                @else

                                    @if($du->ctl_user_id_winner != Auth::user()->id and $du->ctl_user_id_winner!=null)

                                        <tr id="mv_jose_row " class="fenix_duel" style="background-color: #2a9055">

                                    @elseif($du->ctl_user_id_winner == Auth::user()->id and $du->duelstate!=5)
                                        <tr id="mv_jose_row">

                                    @elseif($du->ctl_user_id_winner == Auth::user()->id and $du->duelstate==5)                              {{-- // si el ganador es el logueado (permitira aceptar el don)--}}

                                    <tr id="acept{{$du->id}}" class="don_challenged" style="background-color: #ffd04b" >

                                    @endif
                                @endif
                                    <td>{{$du->tittle}}</td>
                                    <td>${{$du->pot}}.00</td>

                                    <td>{{$du->ctlUser0->username}}</td>
                                    <td>{{$du->ctlUser1->username}}</td>
                                    <td>{{$du->registerDate}}</td>
                                    <td>{{$du->duelstatus->description}}</td>
                                        @if($du->ctl_user_id_winner==null)
                                            <td>--</td>
                                        @else
                                            <td>{{$du->ctlUser3->username}}</td>
                                        @endif
                                    <td hidden>{{$du->id}}</td>


                                    </tr>



                            @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Challenged</th>
                    <th>Stacks</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Winner</th>
                    <th hidden>id</th>
                </tr>
                </tfoot>

            </table>
            {{-- <div class="col-md-12 status-table">
                <div class="card">
                    <div class="card-header">Dewl Status </div>
                    <div class="card-body">

                    </div>
                </div>
            </div> --}}




            </div>
        </div>
    </div>

    <script type="application/javascript">
        $(document).ready(function() {
            $('#mytable').DataTable({
    responsive: true
});
        } );
    </script>
    
                <script type="application/javascript">

                $(document).ready(function() {

                    var table = $('#mytable').DataTable();


                    // CREAR DOBLE O NADA

                    $('#mytable').on('click', 'tr.fenix_duel', function() {

                        var data = table.row( this ).data();
                        console.log('Este es el valor de data que no se que es xd');
                        console.log(data[1]);
                        {{--console.log({{}});--}}
                        var delayInMilliseconds = 1000; //1 second
                        // alertify.confirm('Double or nothing', data[0], function(){ alertify.success('Ok');
                        //     }
                        //     , function(){ alertify.error('Cancel')});

                            alertify.confirm('Double or nothing', 'Come on, one more match, double or nothing!  You agree?', function(){alertify.success('Deleted');
                                    setTimeout(function() {
                                        window.location.replace("/public/double_or_nothing/"+data[7]+"/");
                                    })
                                }
                                , function(){ alertify.error('Cancel')});

                    } );


                //    ACEPTAR DOBLE O NADA

                    $('#mytable').on('click', 'tr.don_challenged', function() {

                        var data = table.row( this ).data();
                        console.log('Este es el valor de data que no se que es xd');
                        console.log(data[1]);
                            {{--console.log({{}});--}}
                        var delayInMilliseconds = 1000; //1 second
                        // alertify.confirm('Double or nothing', data[0], function(){ alertify.success('Ok');
                        //     }
                        //     , function(){ alertify.error('Cancel')});

                        alertify.confirm('You have been challenged by your rival to a double or nothing You agree?', function(){alertify.success('Deleted');
                                setTimeout(function() {
                                    window.location.replace("/public/acepted_don/"+data[7]+"/");
                                })
                            }
                            , function(){ alertify.error("Cancel")});

                    } );
                } );

            </script>







@endsection


