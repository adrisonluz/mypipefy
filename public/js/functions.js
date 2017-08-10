$(document).ready(function() {

    $('.tableDashboard').each(function(){
    	var route = $(this).data('route');

	    $(this).DataTable({
	    	order: [[4, 'asc']],
	    	processing: true,
	        serverSide: true,
	        ajax: route
	    });
    });
} );