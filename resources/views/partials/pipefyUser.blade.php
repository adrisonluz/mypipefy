@push('styles')
<style class="dashboardStyle"></style>
@endpush
<div class="row rowUserTeam">
  <div class="col-xs-12">
    <div class="user-info">
      <img src="{{ $pipefyUser->avatar() }}" title="{{$pipefyUser->name}}" alt="{{$pipefyUser->name}}" class="img-responsive img-thumbnail">
      <div> 
        <h3>{{FirstAndLastName($pipefyUser->name)}} </h3>
        <span>{{'@'.$pipefyUser->username}} | {{$pipefyUser->pipefy_id}}</span>
      </div>
    </div>
  </div>
  <div class="col-md-8" data-userid="{{$pipefyUser->pipefy_id}}">
    <div class="loader-tables" style="display:none;">
      <div class="load-pages">
        <div class="gif-loader">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
    </div>
    <table class="table display responsive no-wrap table-striped table-bordered tableDashboard" data-route="{{ route('api.get_cards_user_id', ['userId' => $pipefyUser->pipefy_id]) }}">
      <thead class="thead-inverse">
        <tr>
          <td>Pipe</td>
          <td>Título</td>
          <td>Cliente</td>
          <td>DUE</td>
          <td>Ações</td>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
    <button type="button" name="button" class="buttonUpdateTable btn btn-primary"><i class="fa fa-refresh"></i> Atualizar cards</button>
  </div>
  <div class="col-md-4 div-calendar">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h4><strong><i class="fa fa-calendar"></i> Tarefas Agendadas</strong></h4>
      </div>
      <div class="panel-body">
        <div class='calendar calendar_{{$pipefyUser->pipefy_id}}' data-userid="{{$pipefyUser->pipefy_id}}" data-route="{{route('api.get_cards_user')}}">
        </div>
        <div class="load-calendario" style="display:none;">
          <div class="load-pages">
            <div class="gif-loader">
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>