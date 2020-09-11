@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center text-center">

                {{--                AQUI EL MENU--}}
            <div class="container">
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

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Create a Dewl</div>
                        <div class="card-body">
                            <form action="/public/re_duel" method="post" onsubmit="sub_butt.disabled = true; return true;">
                                @csrf
{{--                                Tittle--}}
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="tittle" name="tittle" aria-describedby="tittle" disabled value={{$title}}>
                                    <input type="text" class="form-control" id="duel" name="duel" aria-describedby="duel" hidden value={{$duel}}>

                                </div>
{{--                                DESCRIPTION--}}
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="descriptio" class="form-control" cols="30" rows="3" >{{$description}}</textarea>

                                </div>

{{--                                POT--}}
                                <label for="pot">Dewl</label>
                                <div class="input-group mb-3">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">$</span>
                                    </div>
                                    <input type="number" id="pot" name="pot" class="form-control" aria-label="pot" aria-describedby="pot" disabled value={{$amount}}  >
                                </div>

{{--                                RETADO--}}
                                <div class="form-group">
                                    <label for="challendged">VS</label>
                                    <select class="form-control" id="challendged"  name="challendged" disabled >
                                        @foreach($challengeds as $chall)
                                            @if($chall->id == $challenged){
                                            <option value="{{$chall->id}}" > {{ $chall->username }}  </option>
                                        }
                                        @endif
                                        @endforeach

                                    </select>
                                </div>


{{--                                      TESTIGO--}}
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Witness</label>
                                    <select class="form-control" name="witness" id="witness" disabled>
                                        @foreach($challengeds as $chall)
                                            @if($chall->id == $witness){
                                            <option value="{{$chall->id}}" > {{ $chall->username }} </option>
                                        }
                                        @endif
                                        @endforeach
                                    </select>
                                </div>


                                <button type="submit" class="btn btn-danger" id="sub_butt">DEWL</button>
                            </form>
                        </div>
                    </div>
                </div>

            <script>

                console.log("{{$challenged}}  this is the challenged id");

                console.log("{{$witness}}  this is the witness id");

                console.log("{{$title}} this is the tittle of duel");

                console.log("this is the pot");


                var nameInput = document.getElementById('pot');
                console.log(nameInput.value());
            </script>

{{--            <div>--}}
{{--                @foreach($f_root as $groot)--}}
{{--                    {{$groot}}--}}
{{--                    @endforeach--}}
{{--            </div>--}}

        </div>
    </div>
@endsection
