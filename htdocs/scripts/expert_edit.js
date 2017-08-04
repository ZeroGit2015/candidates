// Функция, вызываемая после загрузки страницы и после обработки Ajax запросов
function onLoad() {

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


    // Добавить деятельность
	$("*").on('click', ".activity_add", function() {
		var activity = $("select[name='activity']");
		var div_activity = $("#activity_"+activity.val());
		$("#activity_"+activity.val()).remove();
		var div = $("#activities");
		div.append(
			"<div id='activity_"+activity.val()+"'>"+ $("select[name='activity'] option:selected").text()+"<a id_activity='"+activity.val()+"' class='fa fa-remove activity_del'></a>				<input type='hidden' name='expert_activities[]' value='"+activity.val()+"' /></div>"
		);
		return false;
	});

    // Удалить деятельность
	$("*").on('click', ".activity_del", function() {
		var id_activity = $(this).attr("id_activity");
		$("#activity_"+id_activity).remove();
		return false;		
	});

}

$(document).ready(onLoad);
$(document).ajaxComplete(onLoad);

