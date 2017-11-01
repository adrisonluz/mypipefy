@extends('layouts.app')
@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('plugins/colorpicker/css/bootstrap-colorpicker.min.css') }}">
@endpush
@push('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('plugins/colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script>
    $(function() {
        $('.colorpicker-component').colorpicker({
            colorSelectors: {
                'black': '#000000',
                'white': '#ffffff',
                'red': '#FF0000',
                'default': '#777777',
                'primary': '#337ab7',
                'success': '#5cb85c',
                'info': '#5bc0de',
                'warning': '#f0ad4e',
                'danger': '#d9534f',
            },
            format : 'hex',
        });
        $("button[data-toggle='collapse']").on('click', function(event){
            event.preventDefault();
        });
    });
</script>
@endpush
<div class="container config">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h1>Pipe Configs</h1>
                </div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="panel panel-default">
                        <form action="{{ route('config.pipes.save') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="row">
                                @foreach($pipes as $pipe)
                                    <div class="col-md-4">
                                        <div class="panel-heading">{{ $pipe->name }}<button class="btn btn-xs btn-primary pull-right" data-toggle="collapse" data-target="#{{ $pipe->id }}">&#9660;</button></div>

                                        <div id="{{ $pipe->id }}" class="panel-body collapse">
                                            @foreach($pipe->phases as $phase)
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="checkbox">
                                                          <label><input type="checkbox" name="phase_id[]" value="{{ $phase->id }}" {{ $phase->checked }}>{{ $phase->name }}</label>
                                                      </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group colorpicker-component">
                                                            <input type="text" name="color[{{ $phase->id }}]" class="form-control" value="{{ $phase->color }}">
                                                            <span class="input-group-addon"><i></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary pull-right" type="submit">Salvar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
