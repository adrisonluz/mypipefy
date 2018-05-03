@extends('layouts.app')
@section('content')
    @push('scripts')
    @endpush
    <div class="container config">
        @if (session('status'))
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ session('status') }}
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <a href="{{ route('config.teams.insert') }}" class="btn btn-default"><i class="fa fa-plus"></i> Adicionar time</a>
                    </div>
                    <div class="panel-body">
                        <table class="table display table-general responsive no-wrap table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Time</th>
                                <th>membros</th>
                                <th width="25%">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($teams as $team)
                                <tr>
                                    <td>{{ $team->name }}</td>
                                    <td>
                                        @foreach($team->members as $member)
                                            {{ '@'.$member->pipefyUser->username }}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('config.teams.edit', $team->id) }}" class="btn btn-default"><i class="fa fa-pencil"></i> Editar</a>
                                        <form action="{{route('config.teams.destroy', $team->id)}}" method="post" style="display: inline-block;" class="form-delete">
                                            {{csrf_field()}}
                                            <input name="_method" type="hidden" value="DELETE">
                                            <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i> Deletar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">Cadastre o primeiro time agora mesmo!</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
