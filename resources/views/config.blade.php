@extends('layouts.app')
@section('content')
@push('scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
                    <div class="my-team" data-route="{{ route('config.removeInvite') }}" data-orderroute="{{ route('config.reorder') }}">
                        @foreach($myTeam as $pipefyUser)
                        <div class="row">
                            <div class="col-md-2">
                                <img src="{{$pipefyUser->avatar_url}}" title="{{$pipefyUser->name}}" class="avatar img-responsive img-thumbnail">
                            </div>
                            <div class="col-md-5 name">
                              @if($pipefyUser->name)
                                <span class="name-user">{{ FirstAndLastName($pipefyUser->name) }}</span>
                              @endif
                              @if($pipefyUser->username)
                                <span>{{ '@'.$pipefyUser->username }}</span>
                              @endif
                              @if($pipefyUser->email)
                                <span class="email-user">{{ $pipefyUser->email }}</span>
                              @endif
                            </div>
                            <div class="col-md-5">
                                <button class="btn {{ $pipefyUser->phase }}" data-pipefyid="{{ $pipefyUser->pipefy_id }}"></button>
                            </div>
                        </div>
                        @endforeach
                        <p class="not-have" @if(count($myTeam) > 0) style="display: none;" @endif>Não tem membros no seu time. Convide Alguém.</p>
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
                    <div class="pipefy-users" data-route="{{ route('config.sendInvite') }}">
                        @foreach($users as $user)
                        <div class="row">
                            <div class="col-md-2">
                                <img src="{{$user->avatar_url}}" title="{{$user->name}}" class="avatar img-responsive img-thumbnail">
                            </div>
                            <div class="col-md-5 name">
                              @if($user->name)
                                <span class="name-user">{{ FirstAndLastName($user->name) }}</span>
                              @endif
                              @if($user->username)
                                <span>{{ '@'.$user->username }}</span>
                              @endif
                              @if($user->email)
                                <span class="email-user">{{ $user->email }}</span>
                              @endif
                            </div>
                            <div class="col-md-5">
                                <button class="btn btn-success add-team" data-pipefyid="{{ $user->pipefy_id }}"></button>
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
