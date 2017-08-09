@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs-3.3.7/dt-1.10.15/datatables.min.css"/>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.7/dt-1.10.15/datatables.min.js"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endpush

@section('content')
<div class="container">
    <div class="row">
        {{ csrf_field() }}

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h1>Dashboard</h1>
            </div>

            <div class="panel-body">
                <div class="col-md-8">
                    <table class="table table-striped table-bordered tableDashboard">
                        <thead class="thead-inverse">
                            <tr>
                                <td>ID</td>
                                <td>Pipe</td>
                                <td>Título</td>
                                <td>Cliente</td>
                                <td>DUE</td>
                            </tr>
                        </thead>
                        <tbody>
                        @if (count($myCards) > 0)
                        @foreach($myCards as $pipe)  
                            @foreach($pipe['pipeCards'] as $card)                
                            <tr>
                                <td><a href="https://app.pipefy.com/pipes/{{$pipe['pipeId']}}#cards/{{$card->id}}" target="_blank">{{$card->id}}</a></td>
                                <td><a href="https://app.pipefy.com/pipes/{{$pipe['pipeId']}}" target="_blank">{{$pipe['pipeName']}}</a></td>
                                <td>{{$card->title}}</td>
                                <td>
                                @foreach($card->fields as $field)
                                    @if($field->phase_field->id == 'cliente')
                                    {{str_replace(['["','"]'], '', $field->value)}}
                                    @endif
                                @endforeach
                                </td>

                                <td>
                                @foreach($card->fields as $field)
                                    @if($field->phase_field->id == 'data_prevista_de_entrega')
                                    {{substr($field->value,0,10)}}
                                    @endif
                                @endforeach
                                </td>
                            </tr>  
                            @endforeach              
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            
                <div class="col-md-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4><strong>Gráficos</strong></h4>
                        </div>
                        <div class="panel-body">
                            @if (count($allPipes->pipes) > 0)
                            @foreach($allPipes->pipes as $pipe)
                            <div class="panel panel-default">
                                <div class="panel-heading">{{$pipe->id}}: {{$pipe->name}} <button class="btn btn-xs btn-primary pull-right" data-toggle="collapse" data-target="#{{$pipe->id}}">&#9660;</button></div>

                                <div id="{{$pipe->id}}" class="panel-body collapse">
                                    <div class="chart-container" style="position: relative;">
                                        <canvas id="chart_{{$pipe->id}}"></canvas>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
