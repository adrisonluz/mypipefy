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
            <a href="{{ route('config.filters.insert') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Adicionar filtro</a>
            <br><br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table display table-general responsive no-wrap table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Filtro</th>
                        <th>Criador</th>
                        <th>Responsável</th>
                        <th>Fase</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($filters as $filter)
                        <td>{{ $filter->name }}</td>
                        <td>{{ implode($filter->owners, ', ') }}</td>
                        <td>{{ implode($filter->assignees, ', ') }}</td>
                        <td>{{ implode($filter->phases, ', ') }}</td>
                        <td>
                            <a href="{{ route('config.filters.edit', $filter->id) }}" class="btn btn-default"><i class="fa fa-pencil"></i> Editar</a>
                            <form action="{{route('config.filters.destroy', $filter->id)}}" method="post" style="display: inline-block;" class="form-delete">
                                {{csrf_field()}}
                                <input name="_method" type="hidden" value="DELETE">
                                <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i> Deletar</button>
                            </form>
                        </td>
                    @empty
                        <tr>
                            <td colspan="5">Cadastre seu primeiro filtro agora mesmo!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
