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
                    var diff_days = calculaDias(card.due, true);
                    var classColor = '';

                    if(card.phaseName.toUpperCase() !== 'PENDENTE'){
                        switch(diff_days){
                            case false:
                                classColor = 'normal';
                                break;
                            case 1:
                                classColor = 'atrasado';
                                break;
                            default:
                                classColor = 'very_atrasado';
                        }
                    }else{
                        classColor = 'pendente';
                    }
                    classColor = (classColor != '') ? ' class="'+classColor+'"' : '';

    				var $tr = '<tr data-toggle="tooltip" title="'+card.phaseName+'"'+classColor+'>';
                    $tr += '<td>'+card.link_card+'</td>';
                    $tr += '<td>'+card.link_pipe+'</td>';
                    $tr += '<td>'+card.card_title+'</td>';
                    $tr += '<td>'+card.client_name+'</td>';
    				$tr += '<td>'+card.due+'</td>';
    				$tr += '</tr>';
    				$table.children('tbody').append($tr);
    			});
    		},
    		complete: function(){
               $table.DataTable({
                    order: [[4, 'asc']],
                    language: {
                        url: $("base").attr('href')+'plugins/datatables/languages/Portuguese-Brasil.json'
                    }
                });
    		}
    	});
    });
    $('.mobile-menu-perfil').on('click', function(){
      $('body').toggleClass('menu-perfil-active');
    });
    $('[data-toggle="tooltip"]').tooltip({
        placement: (window.innerWidth < 768) ? 'top' : 'right'
    });
    $(window).scroll(function(){
        if($(this).scrollTop() >= 514){
            $('body').addClass('scrolled');
        }else{
            $('body').removeClass('scrolled');
        }
    });
    $('.click-to-top').on('click', function(){
      $('html,body').animate({ scrollTop:0 }, 800);
    });

    var urlHer = location.pathname;
    if(urlHer == '/mypipefy/public/dashboard' || urlHer == '/mypipefy/public/login' || urlHer == '/mypipefy/public/' || urlHer == '/mypipefy/public/password/reset' ){
      var alturaWindow = window.innerHeight;
      if(alturaWindow >= 637){
      	var alturaApp = $('div#app').height();
      	alturaApp += 151;
      	var margintContainer = alturaWindow - alturaApp
      	$('div#app').css('margin-bottom',margintContainer+'px');
      	margintContainer
      }
    }
});

$(window).on('load', function(){
  $('.loader').fadeOut('slow');
});

function loaderPulse(){
    setInterval(function(){
      $('body').removeClass('rodando');
      setTimeout(function(){
        $('body').addClass('rodando');
      },400);
    },5000);
}

function calculaDias(date1, br){
    if(br == true){
        var arr_date = date1.split('/');
        date1 = arr_date[2]+'-'+arr_date[1]+'-'+arr_date[0];
    }
    var data1 = moment(date1,'YYYY/MM/DD');
    var data2 = moment(getToday(),'YYYY/MM/DD');
    var diff  = data2.diff(data1, 'days');

    return ((diff <= 0) ? false : diff);
}

function getToday(){
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    if(dd<10) {
        dd = '0'+dd
    }

    if(mm<10) {
        mm = '0'+mm
    }

    today = yyyy+'-'+mm+'-'+dd;

    return today;
}
