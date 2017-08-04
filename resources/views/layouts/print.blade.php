<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	
	<!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,400italic,700,700italic,300italic,300&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	<?php // У Lato нет кириллицы ?>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <!-- Styles -->
	
    <style>
        body {
            font-family: 'Roboto Condensed', sans-serif;
			font-size: 14px;
        }

        .fa-btn {
            margin-right: 6px;
        }
		
		span.glyphicon.green {
			color: #5CB85C;
		}
		table.table td.green {
			background: #D9FFDF;
		}

		table.table td.red {
			background: #FFC1B9;
		}

		table.table td.orange {
			background: #FFFBC5;
		}
		
		table.table tr td {
			border: 1px solid #CFCFCF;
			margin: 0;
			padding: 3px 4px;
		}

		.panel-heading {
			font-size: 150%;
			padding: 10px 10px 30px;
		}

		table.table tr th {
			border: 1px solid #000;
			padding: 3px 7px;
		}

		table.table {
			border-spacing: 0;
		}
		
		a {
			text-decoration: none;
			color: #000;
		}
		
		div.form-control {
			/*border: 1px solid #000;*/
			padding: 3px;
			margin: 5px;
			width: 90%;
			min-height: 1em;
			vertical-align: top;
		}
		
		.col-md-3 {
			/*display: inline-block;*/
			width: 24%;
			vertical-align: top;
		}
		
		.col-md-4 {
			/*display: inline-block;*/
			width: 30%;
			vertical-align: top;
		}
		
		.col-md-6 {
			/*display: inline-block;*/
			width: 50%;
			vertical-align: top;
		}
		
		.col-md-12 {
			width: 100%;
			display: block;
			vertical-align: top;
		}
		
		input.form-control, select.form-control {
			width: 90%;
		}
		
		.form-group {
			width: 90%;
			margin-top: 15px;
		}
		
		.text-center {
			text-align: center;
		}
		i.fa.green {
			color: #5CB85C;
		}
		table.table .green td {
			background: #D9FFDF;
		}

		table.table .red td {
			background: #FFC1B9;
		}

		table.table .orange td {
			background: #FFFBC5;
		}
		
		.default_fields > div {
			border-bottom: 1px solid #C7C7C7;
		}
		
		#collapse1 td {
			border: 1px solid #CECECE;
		}
		
		.zag td {
			width: 25%;
		}
		
		table.zag {
			width: 100%;
		}
		
		table.default_fields td {
			border: 1px solid #CECECE;
		}

		table {
			border-spacing: 0;
		}

		table td {
			vertical-align: middle;
		}
    </style>
	<script>
	$(function(){
		$('.candidate_print .ocen_info .form-group, .candidate_print .default_fields .form-group').each(function(){
			var list;
			list = 0;
			
			list = list + $(this).find('.form-control').text().length;
			
			$(this).find('.form-control').each(function(){
				list = list + $(this).text().length;
				
				if($(this).hasClass('fa')) {
					list = list + 1;
				}
			});
			
			
			
			
			$(this).find('.form-control').each(function(){
				list = list + $(this).find('.form-control').text().length;
			});
			
			
			
			
			if(list > 0) {
				
				$(this).show();
			} else {
				$(this).hide();
				if($(this).parents('.ocen_info').length) {
					$(this).prev().hide();
				}
			}
		});
		
	});
	</script>
</head>
<body class="print">
    @yield('content')
</body>
</html>
