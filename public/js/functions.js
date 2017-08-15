$(document).ready(function() {
    $('.tableDashboard').each(function(){
    	var route = $(this).data('route');
    	$table = $(this);
    	$.ajax({
    		url: route,
    		type: 'GET',
    		dataType: 'json',
    		async: false,
    		beforeSend: function(){
    			$table.siblings('.load-datatables').fadeIn();
    		},
    		success: function(data){
    			$.each(data, function(index, card){
    				var tr = '<tr data-toggle="tooltip" title="'+card.phaseName+'">';
                    tr += '<td>'+card.link_card+'</td>';
                    tr += '<td>'+card.link_pipe+'</td>';
                    tr += '<td>'+card.card_title+'</td>';
                    tr += '<td>'+card.client_name+'</td>';
    				tr += '<td>'+card.due+'</td>';
    				tr += '</tr>';
    				$table.children('tbody').append(tr);
    			});
    		},
    		complete: function(){
    			$table.DataTable({
			    	order: [[4, 'asc']],
                    language: {
                        url: $("base").attr('href')+'plugins/datatables/languages/Portuguese-Brasil.json'
                    }
			    });
                // $table.css({width:'auto'});
    		}
    	});
    });
    $('.mobile-menu-perfil').on('click', function(){
      $('body').toggleClass('menu-perfil-active');
    });
    $('[data-toggle="tooltip"]').tooltip({
        placement: 'right'
    });
});
$(window).on('load', function(){
  $('.loader').fadeOut('slow');
});
// function loaderPulse(){
//     setInterval(function(){
//       $('body').removeClass('rodando');
//       setTimeout(function(){
//         $('body').addClass('rodando');
//       },400);
//     },5000);
// }
