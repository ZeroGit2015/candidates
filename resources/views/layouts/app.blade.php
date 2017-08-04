<?php header("Content-Type: text/html; charset=utf-8"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
    <title>Выборы</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,400italic,700,700italic,300italic,300&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	<?php // У Lato нет кириллицы ?>

	@section('styles')
        <!-- Styles -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    
        <style>
            body {
                font-family: 'Roboto Condensed', sans-serif;
				font-size: 14px;
            }
    
            .fa-btn {
                margin-right: 6px;
            }
			
			.panel-heading a:after {
				font-family:'Glyphicons Halflings';
				content:"\e114";
				float: right;
				color: grey;
			}
			
			.panel-heading a.collapsed:after {
				content:"\e080";
			}
			
			.social_net a {
				background: url('/images/icons_mass3.png');
			}
    
			.social_net a {
				width: 50px;
				height: 50px;
				display: inline-block;
				overflow: hidden;
			}
    
			.social_net a.sn_vk {
				background-position: -450px -506px;
			}
    
			.social_net a.sn_fb {
				background-position: -394px -562px;
			}
    
			.social_net a.sn_ok {
				background-position: -226px -394px;
			}
    
			.social_net a.sn_tw {
				background-position: -2px -170px;
			}
    
			.social_net a.sn_lj {
				background-position: -114px -114px;
			}
    
			.social_net a.sn_inst {
				background-position: -339px -562px;
			}
    
			.social_net a.sn_per {
				background-position: -506px -562px;
			}
    
			.social_net a.sn_yt {
				background-position: -227px -562px;
			}
			span.glyphicon.green {
				color: #5CB85C;
			}
			table.table .green td {
				background: #D9FFDF;
			}
			
			.save_button {
				position: fixed;
				bottom: 0px;
				left: 0px;
				width: 100%;
				background: #fff;
				margin: 0;
				padding: 5px;
				border-top: 1px solid #DDD;
			}
    
			table.table .red td {
				background: #FFC1B9;
			}
    
			table.table .orange td {
				background: #FFFBC5;
			}
			
			a.election_del, a.activity_del {
				float: right;
				cursor: pointer;
			}
			
			a.election_add, a.activity_add {
				float: left;
				font-size: 26px;
				padding: 4px;
				cursor: pointer;
			}
			
			a.election_del:hover, a.election_add:hover, a.activity_del:hover, a.activity_add:hover  {
				text-decoration: none
				text-decoration: none
			}
			
			.task-table tr.hidden-row th > div {
				height: 1px;
				overflow: hidden;
			}
			
			.task-table tr {
				background: #fff;
				z-index: 2;
			}
			
			.clearfix {
				clear: both;
			}

			
			.form-horizontal .control-label {
				text-align: left;
			}
			.resize_div {
				resize: both;
				overflow: auto;
			}

			#loading {
				position:absolute; 
				z-index:1000; 
				display:none
			}
	
	        /* Аналог label для просмотра кандидата */
			.font-label-view {
				vertical-align: top;
				font-weight: bold;
				font-size: 14px;
			}

			/* Таблица для просмотра кандидата */
			.form-view td {
			 	padding : 5px;
			}
			
        </style>
	@show
</head>
<body id="app-layout">
	<img id="loading" src="/images/loading.gif" />	
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="logo" href="{{ url('/') }}">
                    <img src="/images/mainlogo.png" />
                </a>

            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
			
                
                <!-- Left Side Of Navbar -->
                @if (!Auth::guest())
	                <ul class="nav navbar-nav">
   	                	<li><a href="{{ url('/') }}"><b>Главная</b></a></li>
    	                <li><a href="{{ url('/candidates') }}">Кандидаты</a></li>
    	                <li><a href="{{ url('/experts') }}">Эксперты</a></li>
    	                <li><a href="{{ url('/logs') }}">Журнал</a></li>
                    </ul>
        	    @endif

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (!Auth::guest())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Выход</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @if (Session::has("message"))
    	<div class='alert alert-danger fade in'>
    		{{ Session::pull("message", "") }}
    		<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
    	</div>
    @endif

    @yield('content')

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
	
	<script>
	$(function(){
		
		$('.candidates .task-table thead tr').clone().addClass("hidden-row").appendTo(".task-table thead");
		

		$(".candidates .task-table thead tr th").css({boxSizing: 'border-box'});
		
		
		$(".candidates .task-table thead tr th div, .candidates .task-table thead tr th span").each(function(){
			$(this).html($.trim($(this).html().replace(/[\t\n]+/g,' ')));
		});
		
		$(window).scroll(function() {
			var top = $(document).scrollTop();
			if (top < 420 + $('.settings_panel').height()) {
				$(".candidates .task-table thead tr:not(.hidden-row) th").css({boxSizing: 'border-box'});
				$(".candidates .task-table thead tr:not(.hidden-row)").css({top: '0', position: 'relative'});
				$(".candidates .task-table thead tr.hidden-row th > div").css({height: '1px'});
			}
			else {
				$(".candidates .task-table thead tr:not(.hidden-row)").css({top: '0px', position: 'fixed'});
				$(".candidates .task-table thead tr.hidden-row th > div").css({height: 'auto'});
				
				
				
				$('.candidates .task-table thead tr.hidden-row th').each(function(){
					$('.candidates .task-table thead tr:not(.hidden-row) th').eq($(this).index()).css({width: $(this).width(), boxSizing: 'content-box'});
				});
				
			}
		});
		
	
	
	// Отлавливаем изменения, чтобы предупредить о несохранении
	pageChanged = Boolean(false);
	$('.candidate_edit input, .candidate_edit textarea').on('input',function(e){
		pageChanged = true;
	});
	
	$('.candidate_edit input[type=checkbox]').click(function(){
		pageChanged = true;
	});
	
	$('.save_candidate').click(function(){
		pageChanged = false;
	});

	$(window).bind('beforeunload', function(){
		if (pageChanged) {
			return 'Если вы закроете эту страницу, то введенные данные не сохранятся \n\nЧтобы данные сохранились, надо остаться на этой странице и нажать на ней  "сохранить"';
		}

	});
		
	});
	
	

	</script>

	@section('scripts')
	@show

</body>
</html>
