@extends('layouts.app')
@section('content')
@push('scripts')
<script src="{{ asset('js/config.js') }}"></script>
@endpush
<div class="container config">
    <div class="row">
        {{-- My Team --}}
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h1>Meu time</h1>
                </div>
                <div class="panel-body myteam">
                    <div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Pesquisar Membros" name="memberFilter">
                                </div>
                            </div>
                        </div>
                      </div>
                    <div class="my-team">
                      <p class="not-have">Não tem ninguém no seu time. Convide Alguém.</p>
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
                <div class="panel-body myteam">
                    <div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Pesquisar usuários" name="filter">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pipefy-users">
                        @foreach($users as $user)
                        <div class="row">
                            <div class="col-md-2">
                                <img src="{{$user->avatar_url}}" title="{{$user->name}}" class="avatar img-responsive img-thumbnail">
                            </div>
                            <div class="col-md-5 name">
                              @if($user->name)
                                <span class="name-user">{{ $user->name }}</span>
                              @endif
                              @if($user->username)
                                <span>{{ '@'.$user->username }}</span>
                              @endif
                              @if($user->email)
                                <span>{{ $user->email }}</span>
                              @endif
                            </div>
                            <div class="col-md-5">
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
