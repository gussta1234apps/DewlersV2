@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center text-center">

                {{--                AQUI EL MENU--}}
                {{--                <a href="/save_duel"><div class="btn btn-primary">Save</div></a>--}}


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
                    <div class="col text-right"></div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Add Stacks</div>
                        <div class="card-body">
                            <form action="/public/savecoins" method="post">
                                @csrf
                                {{--                                Tittle--}}
                                <div class="container">
                                <div class="form-group ">
                                    <label for="tittle" class="deposit">How much do you want to deposit?</label>
                                    <br>
{{--                                    <div class="btn-group btn-group-toggle radios" data-toggle="buttons">--}}
{{--                                        <label class="btn btn-secondary active">--}}
{{--                                            <input type="radio" name="option" id="option1" value="20" checked> $20.00--}}
{{--                                        </label>--}}
{{--                                        <label class="btn btn-secondary">--}}
{{--                                            <input type="radio" name="option" id="option2" value="60"> $60.00--}}
{{--                                        </label>--}}
{{--                                        <label class="btn btn-secondary">--}}
{{--                                            <input type="radio" name="option" id="option3" value="100"> $100.00--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
                                    <select id="amount" name="amount">
                                        <option value="200">$10.25 = 200 Stacks</option>
                                        <option value="400">$20.50 = 400 Stacks</option>
                                        <option value="2000">$102.50 = 2000 Stacks</option>
                                        <option value="10000">$512.50 = 10000 Stacks</option>
                                        <option value="20000">$1025.00 = 20000 Stacks</option>
                                        <option value="100000">$5125.00 = 100000 Stacks</option>
                                        <option value="200000">$1250.00 = 200000 Stacks</option>
                                        <option value="1000000">$51250.50 = 1000000 Stacks</option>
                                        <option value="2000000">$102,500.00 = 2000000 Stacks</option>
                                        <option value="200000000">$1025000,500.00 = 200000000 Stacks</option>
                                    
                                    </select>
                                </div>

                                {{--                                POT--}}
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Stacks</span>
                                    </div>
                                    <input type="number" id="ownAmount" name="ownAmount" class="form-control" placeholder="Own Amount" aria-label="pot" aria-describedby="pot" min="20">
                                </div>

                                {{--                                RETADO--}}



                                {{--                                      TESTIGO--}}



                                <button type="submit" class="btn btn-success">DEPOSIT</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>




        </div>
    </div>
@endsection
