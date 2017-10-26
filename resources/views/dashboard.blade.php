@extends('layouts.app')

@push('styles')
<link rel='stylesheet' href="{{ asset('plugins/fullcalendar/fullcalendar.min.css') }}" />
<link rel='stylesheet' href="{{ asset('plugins/datatables/css/datatables.min.css') }}" />
<link rel='stylesheet' href="{{ asset('plugins/datatables/css/dataTables.bootstrap.min.css') }}" />
<link rel='stylesheet' href="{{ asset('plugins/datatables/css/responsive.bootstrap.min.css') }}" />
@endpush

@push('scripts')
<script src="{{ asset('plugins/fullcalendar/lib/moment.min.js') }}"></script>
<script src="{{ asset('plugins/fullcalendar/fullcalendar.js') }}"></script>
<script src="{{ asset('plugins/fullcalendar/locale/pt-br.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/datatables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/responsive.bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/sorting-uk.js') }}"></script>
<script src="{{ asset('js/team.js') }}"></script>
@endpush

@section('content')
<div class="container">
  <div class="row">
    {{ csrf_field() }}

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h1>Dashboard</h1>
                <button type="button" name="button" class="open-description-example btn btn-primary">Modal Exemplo</button>
      </div>

      <div class="panel-body">
        @include('partials.pipefyUser', $pipefyUser)
      </div>
    </div>
  </div>
</div>
@endsection
