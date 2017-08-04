// Функция, вызываемая после загрузки страницы и после обработки Ajax запросов
function onLoad() {

	// Защита от CSRF
	$.ajaxSetup({
	    headers: {
			'X-CSRF-Token': $('input[name="_token"]').val()
	    }
	});

	// Выбор региона
	$('#election_region').unbind('change.candidates');
	$("#election_region").bind("change.candidates", function() {
		var election_region = $("#election_region").val();
		startLoadingAnimation();
		var select = $("#election_group");
		select.find("option").remove();
		selectpicker_clear("#election_name");
		selectpicker_clear("#election_status");
		$.ajax({
			type: "post",
  	  	    url: "/ajax/get-election-groups",
  	  	    data: {election_region:election_region},
        	success: function(response) {
				stopLoadingAnimation();
        		var obj = eval("("+response+")");
        		if (typeof(obj)=='object') {
	        		if (obj.result.status=='OK') {
						$.each(obj.result.election_groups, function(i, val) {	
							if (select.find("option[value='"+val+"']").length==0) {
								select.append($('<option>').text(val).attr('value', val));
							}
						});
						if (select.find("option").length==2) {
							select.val(select.find("option").get(1).value);
						}
						$(select).selectpicker('refresh');
						select.change();
            		}
        		}
        	},
		    async: true,
            error: function () {
            }
		});
	});
	
	// Выбор группы
	$('#election_group').unbind('change.candidates');
	$("#election_group").bind("change.candidates", function() {
		var election_region = $("#election_region").val();
		var election_group  = $("#election_group").val();
		startLoadingAnimation();
		var select = $("#election_name");
		select.find("option").remove();
		selectpicker_clear("#election_status");
		$.ajax({
			type: "post",
  	  	    url: "/ajax/get-election-names",
  	  	    data: {election_region:election_region, election_group:election_group},
        	success: function(response) {
				stopLoadingAnimation();
        		var obj = eval("("+response+")");
        		if (typeof(obj)=='object') {
	        		if (obj.result.status=='OK') {
						$.each(obj.result.election_names, function(i, val) {	
							if (select.find("option[value='"+val+"']").length==0) {
								select.append($('<option>').text(val).attr('value', val));
							}
						});
						if (select.find("option").length==2) {
							select.val(select.find("option").get(1).value);
						}
						$(select).selectpicker('refresh');
            		}
        		}
        	},
		    async: true,
            error: function () {
            }
		});
	});
		
	// Выбор наименования
	$('#election_name').unbind('change.candidates');
	$("#election_name").bind("change.candidates", function() {
		var election_region = $("#election_region").val();
		var election_group  = $("#election_group").val();
		var election_name  = $("#election_name").val();
		startLoadingAnimation();
		var select = $("#election_status");
		select.find("option").remove();
		$.ajax({
			type: "post",
  	  	    url: "/ajax/get-election-statuses",
  	  	    data: {election_region:election_region, election_group:election_group, election_name:election_name},
        	success: function(response) {
				stopLoadingAnimation();
        		var obj = eval("("+response+")");
        		if (typeof(obj)=='object') {
	        		if (obj.result.status=='OK') {
						$.each(obj.result.election_statuses, function(i, val) {	
							if (select.find("option[value='"+val+"']").length==0) {
								select.append($('<option>').text(val).attr('value', i));
							}
						});
						if (select.find("option").length==2) {
							select.val(select.find("option").get(1).value);
						}
						$(select).selectpicker('refresh');
            		}
        		}
        	},
		    async: true,
            error: function () {
            }
		});
		
	});
}

// Очистка опций selectpicker
function selectpicker_clear(elm) {
	$(elm).find("option").remove();
	$(elm).selectpicker('refresh');
}

$(document).ready(onLoad);
$(document).ajaxComplete(onLoad);

