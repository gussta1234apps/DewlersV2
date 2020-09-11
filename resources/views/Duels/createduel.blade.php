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
                            <form action="/public/saveduel" method="post" onsubmit="sub_butt.disabled = true; return true;">
                                @csrf
{{--                                Tittle--}}
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="tittle" name="tittle" aria-describedby="tittle" required>
                                </div>
{{--                                DESCRIPTION--}}
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" cols="30" rows="3" required></textarea>

                                </div>

{{--                                POT--}}
                                <label for="pot">Dewl</label>
                                <div class="input-group mb-3">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Stacks</span>
                                    </div>
                                    <input type="number" id="pot" name="pot" class="form-control" placeholder="10.00" aria-label="pot" aria-describedby="pot"  required min="10" >
                                </div>

{{--                                RETADO--}}
                                <div class="form-group">
                                    <label for="challendged">VS</label>
                                    <select class="form-control" id="challendged"  name="challendged" >
                                        @foreach($challengeds as $chall)
                                            <option value="{{$chall->id}}" > {{ $chall->username }} </option>
                                        @endforeach

                                    </select>
                                </div>


{{--                                      TESTIGO--}}
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Witness</label>
                                    <select class="form-control" name="witness" id="witness">
                                        @foreach($challengeds as $chall)
                                            <option value="{{$chall->id}}" > {{ $chall->username }} </option>
                                        @endforeach
                                    </select>
                                </div>


                                <button type="submit" class="btn btn-danger" id="sub_butt">DEWL</button>
                            </form>
                        </div>
                    </div>
                </div>

{{--            <div>--}}
{{--                @foreach($f_root as $groot)--}}
{{--                    {{$groot}}--}}
{{--                    @endforeach--}}
{{--            </div>--}}

        </div>
    </div>
@endsection
