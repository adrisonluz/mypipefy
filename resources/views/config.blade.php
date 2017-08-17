@extends('layouts.app')
@section('content')
@push('scripts')
    <script>
        $(".container").delegate('.pipefy-users .add-team', 'click', function(event) {
            var pipefy_id = $(this).data('pipefyid');
            var $row = $(this).parent().parent();
            var $clone = $row.clone();
            $clone.find('button').removeClass('add-team').addClass('pending');
            $row.remove();
            $(".my-team").prepend($clone);
        });

         $(".container").delegate('.my-team button', 'click', function(event) {
            var pipefy_id = $(this).data('pipefyid');
            var $row = $(this).parent().parent();
            var $clone = $row.clone();
            $clone.find('button').addClass('add-team').removeClass('pending');
            $row.remove();
            $(".pipefy-users").prepend($clone);
        });

        $("[name=filter]").on('keyup', function(){
            var pesquisa = $(this).val();
            pesquisa = pesquisa.toUpperCase();
            $(".pipefy-users .name").each(function(){
                if($(this).text().toUpperCase().indexOf(pesquisa) >= 0)
                    $(this).parent().show('fast');
                else
                    $(this).parent().hide('fast');
            });
            ajustaLayout();
        });
    </script>
@endpush
@push('styles')
    <style>
        .my-team button:before{
            content: "\f00d";
            margin-right: 2px;
            font-family: FontAwesome;
        }
        .my-team button.on-team:after{
            content: 'Remover do time'
        }
        .my-team button.pending:after{
            content: 'Aguardando aprovação'
        }
        .pipefy-users button.add-team:after{
            content: 'Vem para o meu Time!';
        }
    </style>
@endpush
<div class="container">
    <div class="row">
        {{-- My Team --}}
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h1>Meu time</h1>
                </div>
                <div class="panel-body">
                    <div class="my-team">
                        {{-- @for($i=0;$i<4;$i++) --}}
                        {{-- <div class="row" style="border-bottom: 1px solid #ccc">
                            <div class="col-md-1">
                                <img src="{{$me->avatar_url}}" title="{{$me->name}}" class="avatar img-responsive img-thumbnail">
                            </div>
                            <div class="col-md-3">
                                <span>{{ $me->name }}</span>
                                <span>{{ ($me->username != '') ? '@'.$me->username : '' }}</span>
                                <span>{{ $me->email }}</span>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-default on-team" data-pipefyid="{{ $me->id }}"></button>
                            </div>
                        </div>
                        @endfor --}}
                    </div>
                </div>
            </div>
        </div>
        {{-- Users --}}
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h1>Usuários</h1>
                </div>
                <div class="panel-body">
                    <div>
                        <div class="row" style="border-bottom: 1px solid #ccc">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Pesquisar usuários" name="filter">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pipefy-users">
                        @foreach($users as $user)
                        <div class="row" style="border-bottom: 1px solid #ccc">
                            <div class="col-md-1">
                                <img src="{{$user->avatar_url}}" title="{{$user->name}}" class="avatar img-responsive img-thumbnail">
                            </div>
                            <div class="col-md-3 name">
                                <span>{{ $user->name }}</span>
                                <span>{{ ($user->username != '') ? '@'.$user->username : '' }}</span>
                                <span>{{ $user->email }}</span>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-default add-team" data-pipefyid="{{ $user->pipefy_id }}"></button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
