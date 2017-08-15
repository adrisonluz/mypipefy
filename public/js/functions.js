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
    			$.each(data, function(index, row){
    				var tr = '<tr>';
    				$.each(row, function(indexCollumn, collumn){
    					tr += '<td>'+collumn+'</td>';
    				});
    				tr += '</tr>';
    				$table.children('tbody').append(tr);
    			});
    		},
    		complete: function(){
    			$table.siblings('.load-datatables').fadeOut();
    			$table.DataTable({
			    	order: [[4, 'asc']]
			    });
          $table.css({width:'auto'});
    		}
    	});
    });
});
$(window).on('load', function(){
  $('.loader').fadeOut('slow');
});
