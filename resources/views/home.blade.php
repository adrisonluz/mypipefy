@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="msg_home">
                        <imge>
                            <img src="{{ asset('img/mypipefy.png') }}">
                        </image>

                        <div class="welcome">
                            <h1>MyPipefy</h1>
                            <p>Seja bem vindo!</p>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
