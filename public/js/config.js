$(function(){
  $(".container").delegate('.pipefy-users .add-team', 'click', function(event) {
      var pipefy_id = $(this).data('pipefyid');
      var $row = $(this).parent().parent();
      var $clone = $row.clone();
      $clone.find('button').removeClass('add-team').addClass('pending');
      $row.remove();
      $(".my-team").prepend($clone);
      $('p.not-have').fadeOut();
  });

   $(".container").delegate('.my-team button', 'click', function(event) {
      var pipefy_id = $(this).data('pipefyid');
      var $row = $(this).parent().parent();
      var $clone = $row.clone();
      $clone.find('button').addClass('add-team').removeClass('pending');
      $row.remove();
      $(".pipefy-users").prepend($clone);

      var numberRowTeam = $('.my-team .row').length;
      if(!numberRowTeam){$('p.not-have').fadeIn();}
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

});
$(window).on('load', function(){
    console.clear();
    $('.config img.avatar.img-responsive.img-thumbnail').each(function(){
    	var alturaImage = $(this).height();
    	var tamanhoImage = $(this).width();
    	if(alturaImage !== 64 || tamanhoImage !== 64){
    		$(this).attr('src','/mypipefy/public/img/mypipefy.png');
    	}
    });
});
