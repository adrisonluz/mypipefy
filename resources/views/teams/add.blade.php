@extends('layouts.app')
@section('content')
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
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
        <div class="col-md-6">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h1>Incluír/alterar time</h1>
            </div>
            <div class="panel-body">
                <form action="{{ route('config.teams.save') }}" method="POST">
                    <div class="form-group">
                        <label for="name">Nome do time</label>
                        <input type="text" name="name" value="{{ $team->name }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="member">Membros</label>
                        <select name="member_id[]" multiple class="form-control selectpicker" data-live-search="true">
                            @foreach ($members as $member)
                            @if (in_array($member->pipefy_id, $members_selected))
                            <option selected value="{{ $member->pipefy_id }}" data-subtext="{{ '@'.$member->username }}">{{ $member->name }}</option>
                            @else
                            <option value="{{ $member->pipefy_id }}" data-subtext="{{ '@'.$member->username }}">{{ $member->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $team->id }}">
                    <input type="submit" value="Salvar" class="btn btn-primary pull-right">
                    <a href="{{ route('config.teams') }}" class="btn btn-default pull-right" style="margin-right: 5px;">Voltar</a>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
