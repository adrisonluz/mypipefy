jQuery(document).ready(function($) {
  var _token = $('input[name=_token]').val();
  $(".container").delegate('.pipefy-users .add-team', 'click', function(event) {
    var $botao = $(this);
    $botao.prop('disabled', true);
    var pipefy_id = $(this).data('pipefyid');
    var $row = $(this).parent().parent();
    var $clone = $row.clone();
    $.ajax({
      url: $(".pipefy-users").data('route'),
      type: 'POST',
      dataType: 'json',
      data: {
        pipefy_id: pipefy_id,
        _token: _token
      },
      success: function(result){
        if(result.success){
          $clone.find('button').removeClass('add-team').addClass('pending').prop('disabled', false);
          $row.remove();
          $(".my-team").prepend($clone);
          $('p.not-have').fadeOut();
        }else{
          $botao.prop('disabled', false);
        }
      },
      error: function(){
        $botao.prop('disabled', false);
      }
    });
  });

  $(".container").delegate('.my-team button', 'click', function(event) {
    var $botao = $(this);
    $botao.prop('disabled', true);
    var pipefy_id = $(this).data('pipefyid');
    var $row = $(this).parent().parent();
    var $clone = $row.clone();

    $.ajax({
      url: $(".my-team").data('route'),
      type: 'POST',
      dataType: 'json',
      data: {
        pipefy_id: pipefy_id,
        _token: _token
      },
      success: function(result){
        if(result.success){
          $clone.find('button').addClass('add-team').removeClass('pending').prop('disabled', false);
          $row.remove();
          $(".pipefy-users").prepend($clone);

          if($('.my-team .row').length == 0){
            $('p.not-have').fadeIn();
          }
        }else{
          $botao.prop('disabled', false);
        }
      },
      error: function(){
        $botao.prop('disabled', false);
      }
    });
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
  });

  $("[name=memberFilter]").on('keyup', function(){
    var pesquisa = $(this).val();
    pesquisa = pesquisa.toUpperCase();
    $(".my-team .name").each(function(){
      if($(this).text().toUpperCase().indexOf(pesquisa) >= 0)
        $(this).parent().show('fast');
      else
        $(this).parent().hide('fast');
    });
  });

  $(".my-team").sortable({
      stop: function(){
        reorder();
      }
  });
  $(".my-team").disableSelection();

  function reorder(){
    var order = [];

    $(".my-team .row").each(function(index){
        var pipefyid = $(this).find('[data-pipefyid]').data('pipefyid');
        order[index] = pipefyid;
    });

    $.ajax({
      url: $(".my-team").data('orderroute'),
      type: 'POST',
      dataType: 'json',
      data: {
        order: order,
        _token: _token
      }
    });
  }
});

$(window).on('load', function(){
  console.clear();
  $('.config img.avatar.img-responsive.img-thumbnail').each(function(){
    var alturaImage = $(this).height();
    var tamanhoImage = $(this).width();
    if(alturaImage !== 64 || tamanhoImage !== 64){
      $(this).attr('src', $("base").attr('href')+'img/mypipefy.png');
    }
  });
});
