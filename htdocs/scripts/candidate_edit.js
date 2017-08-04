// Функция, вызываемая после загрузки страницы и после обработки Ajax запросов
function onLoad() {

	$('.selectpicker').selectpicker({width:'100%'});

	// Защита от CSRF
	$.ajaxSetup({
	    headers: {
			'X-CSRF-Token': $('input[name="_token"]').val()
	    }
	});


	$('.datepicker').datepicker({
    	format: 'dd.mm.yyyy',
    	language: 'ru',
    	autoclose: true
	});


    // Добавить выборы
	$('.election_add').unbind('click');
	$(".election_add").click(function() {
		var election = $("select[name='election']");
		if (election.val()!='' && $("#election_"+election.val()).length==0) {
			var div_activity = $("#election_"+election.val());
			$("#election_"+election.val()).remove();
			var div = $("#elections");
			// Выборы
			var append = $("select[name='election'] option:selected").text()+"<a id_election='"+election.val()+"' class='fa fa-remove election_del'></a><input type='hidden' name='candidate_elections[]' value='"+election.val()+"' />";
			// Округа
			$.ajax({
					type: "post",
      			    url: "/ajax/get-election-for-form-edit",
      			    data: {id_election : election.val()},
	        		success: function(response) {
            	        		var obj = eval("("+response+")");
               	        		if (typeof(obj)=='object') {
									div.append(obj.result);
               	        		}
	        		}
	        });



		}
		return false;
	});

    // Удалить выборы
	$('.election_del').unbind('click');
	$("*").on('click', ".election_del", function() {
		var id_election = $(this).attr("id_election");
		$("#election_"+id_election).remove();
		return false;		
	});

    // Добавить деятельность
	$("*").on('click', ".activity_add", function() {
		var activity = $("select[name='activity']");
		if (activity.val()!='') {
			var div_activity = $("#activity_"+activity.val());
			$("#activity_"+activity.val()).remove();
			var div = $("#activities");
			div.append(
				"<div id='activity_"+activity.val()+"'>"+ $("select[name='activity'] option:selected").text()+"<a id_activity='"+activity.val()+"' class='fa fa-remove activity_del'></a>				<input type='hidden' name='candidate_activities[]' value='"+activity.val()+"' /></div>"
			);
		}
		return false;
	});

    // Удалить деятельность
	$('.activity_del').unbind('click');
	$("*").on('click', ".activity_del", function() {
		var id_activity = $(this).attr("id_activity");
		$("#activity_"+id_activity).remove();
		return false;		
	});

	// Сохранение кандидата
	$('#action').unbind('click');
	$("#action").click(function(event) {
		
		event.preventDefault();
		var button = $(this);
		button.prop("disabled", true);

		startLoadingAnimation();
		$.ajax({
				type: "post",
      		    url: "/ajax/check-candidate",
      		    data: $("#formCandidate").serialize(),
	        	success: function(response) {
	        		stopLoadingAnimation();
	        		var save = false;
   	        		var obj = eval("("+response+")");
   	        		if (typeof(obj)=='object') {
   	        			switch (obj.status) {
   	        				case 'double':
			        			if (confirm(obj.message)) {
 									save = true;
			        			} else {
			        				button.prop("disabled", false);
			        			}
   	        					break;
   	        				case "OK":
								save = true;
   	        					break;
   	        			}
		        		if (save) {
							startLoadingAnimation();
							$.ajax({
								type: "post",
  	  	  	  	      		    url: "/ajax/save-candidate",
  	  	  	  	      		    data: $("#formCandidate").serialize(),
                	        	success: function(response) {
					        		stopLoadingAnimation();
                	        		var obj = eval("("+response+")");
                	        		if (typeof(obj)=='object') {
	                	        		if (obj.status=='OK') {
    	            	        			$("#formCandidate").trigger('reset');
											$(window).unbind('beforeunload');
    	            	        			window.location.href = obj.href;
        	        	        		} else {
        	        	        			alert(obj.status);
					        				button.prop("disabled", false);
        	        	        		}
                	        		}
                	        	},
						        async: true,
                	       	    error: function () {
                	       	    }
							});
	        			}
	        		}
	        	},
		        async: true,
	       	    error: function () {
	       	    }
		});
		return false;
	});
}

$(document).ready(onLoad);
$(document).ajaxComplete(onLoad);

