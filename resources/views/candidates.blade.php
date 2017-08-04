@extends('layouts.app')


@section('scripts')
	@parent
	<script src="{{asset('/scripts/modules/select/js/bootstrap-select.min.js')}}"></script>
	<script src="{{asset('/scripts/modules/select/js/i18n/defaults-ru_RU.js')}}"></script>
	<script src="{{asset('/scripts/functions.js')}}"></script>
	<script src="{{asset('/scripts/candidates.js?v=2')}}"></script>
@stop


@section('styles')
	@parent
	<link rel="stylesheet" href="{{asset('/scripts/modules/select/css/bootstrap-select.css')}}" />
@stop


@section('content')
<div class="container candidates">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default settings_panel">
				<div class="panel-heading ">
					<a data-toggle="collapse" href="#collapse1">Настройка</a>
					<div id="collapse1" class="panel-collapse collapse">
						<form class="form-horizontal" role="form" method='post' action='/candidates'>

							{!! csrf_field() !!}
							
							@foreach($showFields AS $key => $value)
								@if ($value['field'])
									<div class="col-md-6"><label><input type='checkbox' name='{{ $key }}' value='1' @if ($value['visible']) {{ 'checked' }} @endif /> {{ $value['name'] }}</label></div>
								@endif
							@endforeach

							<div class="row">
								<div class="col-md-12">
									<button type="submit" name='action' value='setFieldsForShow' class="btn btn-primary">
										<i class="fa fa-save"></i> Сохранить
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
			
				<a class="btn btn-success pull-right" href='/candidates/print' style='margin:3px' target='_blank'>
					<i class="fa fa-print"></i> Печатать
				</a>
				<a class="btn btn-success pull-right " href='/candidates/add' style='margin:3px'>
				  	<i class="fa fa-plus"></i> Добавить
   				</a>
				<div class="panel-heading">
					Кандидаты. Показано записей: {{ count($results) }}.
				</div>

				<div class="panel-body">
					<div>
					   	@if (@$params['candidates']['filters'])
					   		<h4>
								Установлен фильтр: 
							</h4>
							<ul>
								@foreach($params['candidates']['filters'] AS $key => $value)
									@if ($value['active'])
										<li>
											{{ $value['name'] }} 
										</li>	
									@endif	
								@endforeach
					   		</ul>
							<hr/>
					   	@endif
					</div>
					<form class="form-horizontal" role="form" method='post' action='/candidates'>
						{!! csrf_field() !!}
						<div class="panel panel-success">
							<div class="panel-heading">Ищем по</div>
							<div class="panel-body">

								<div class="row">
									<div class="col-sm-2">
								
										<label><input type='radio' name='search' value='fio' @if (!@$params['candidates']['filters']['search']['value'] or @$params['candidates']['filters']['search']['value']=='fio') {{ 'checked' }} @endif /> Ф.И.О. </label>
										<br />
									
										<label><input type='radio' name='search'  value='all' @if (@$params['candidates']['filters']['search']['value']=='all') {{ 'checked' }} @endif /> любому полю </label>
									
									</div>
									<div class="col-sm-8">
										<div class="form-group">
											<input type='text' name='value' size='90' class="form-control" value='{{ $params['candidates']['filters']['value']['value'] or ''}}' />
										</div>	
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-success">
							<div class="panel-heading">
								Выборы 
								<a href="#" data-toggle="tooltip" title="Отбор кандидатов, участвующих в определнных выборах. Можно выбрать все выборы региона, все выборы округа (для Москвы) или конкретные выборы. Также можно отобрать кандидатов, имеющих определенный статус ('на рассмотрении') и т.п.)"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a>
							</div>
							<div class="panel-body">
								
								<div class="row">
									<div class="col-sm-3">
										<label class="control-label">
											Регион
									</label>
									<div class="form-group">
										<select name='election_region' id='election_region' data-live-search="true" class="form-control selectpicker" >
											<option value=''></option>
											@foreach($election_regions as $key => $value)
												<option value='{{ $value->region }}' @if ($value->region==@$params['candidates']['filters']['election_region']['value']) {{ 'selected' }} @endif >
													{{ $value->region }}
												</option>
											@endforeach
											</select>
										</div>
									</div>

									<div class="col-sm-3">
										<label class="control-label">
											Округ, район
										</label>
										<div class="form-group">
											<select name='election_group' id='election_group' data-live-search="true" class="form-control selectpicker">
												<option value=''></option>
												@foreach($election_groups as $key => $value)
													<option value='{{ $value->group }}' @if ($value->group==@$params['candidates']['filters']['election_group']['value']) {{ 'selected' }} @endif >
														{{ $value->group }}
													</option>
												@endforeach
											</select>
										</div>
									</div>
							
							
									<div class="col-sm-3">
										<label class="control-label">
											Наименование
										</label>
										<div class="form-group">
											<select name='election_name' id='election_name' data-live-search="true" class="form-control selectpicker">
												<option value=''></option>
												@foreach($election_names as $key => $value)
													<option value='{{ $value->name }}' @if ($value->name==@$params['candidates']['filters']['election_name']['value']) {{ 'selected' }} @endif >
														{{ $value->name }}
													</option>
												@endforeach
											</select>
										</div>
									</div>
							
									<div class="col-sm-3">
										<label class="control-label">
											Статус
										</label>
										<div class="form-group">
											<select name='election_status' id='election_status' data-live-search="true" class="form-control selectpicker">
												<option value=''></option>
												@foreach($election_statuses as $key => $value)
													<option value='{{ $value->id }}' @if ($value->id==@$params['candidates']['filters']['election_status']['value']) {{ 'selected' }} @endif >
														{{ $value->name }}
													</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
							</div>	
						</div>

						<div class="panel panel-success">
							<div class="panel-heading">
								Кандидат
								<a href="#" data-toggle="tooltip" title="Отбор кандидатов по региону, указанному в их карточке. Здесь можно отобрать и тех кандидатов, которые пока не привязаны к выборам"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a>
							</div>
							<div class="panel-body">

								<div class="row">
									<div class="col-sm-3">
										<label class="control-label">
											Регион
										</label>
										<div class="form-group">
											<select name='id_region' class="form-control" >
												@foreach($regions as $key => $value)
													<option value='{{ $value->id }}' @if ($value->id==@$params['candidates']['filters']['id_region']['value']) {{ 'selected' }} @endif >
														{{ $value->name }}
													</option>
												@endforeach
											</select>
										</div>
									</div>
						
									<div class="col-sm-3">
										<label class="control-label">
											Куратор
										</label>
										<div class="form-group">
											<select name='kurator' class="form-control" >
												<option value=''></option>
												@foreach($kurators as $key => $value)
													<option value='{{ $value->kurator }}' @if ($value->kurator==@$params['candidates']['filters']['kurator']['value']) {{ 'selected' }} @endif >
														{{ $value->kurator }}
													</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-sm-3">
										<label class="control-label">
											Деятельность
										</label>
										<div class="form-group">
											<select name='activity' class="form-control" >
												<option value=''></option>
												@foreach($activities as $key => $value)
													<option value='{{ $value->id }}' @if ($value->id==@$params['candidates']['filters']['activity']['value']) {{ 'selected' }} @endif >
														{{ $value->name }}
													</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="panel panel-success">
							<div class="panel-heading">Другое</div>
							<div class="panel-body">

								<div class="row">

									<div class="col-sm-1">
										<div class="form-group">
											<label class="control-label"> <input type='checkbox' name='is_not_empty[]' value='vip' @if (is_array(@$params['candidates']['filters']['is_not_empty']['value']) AND in_array('vip', @$params['candidates']['filters']['is_not_empty']['value'])) {{ 'checked' }} @endif /> VIP</label>
										</div>					
									</div>
					
									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label"> <input type='checkbox' name='is_not_empty[]' value='party' @if (is_array(@$params['candidates']['filters']['is_not_empty']['value']) AND in_array('party', @$params['candidates']['filters']['is_not_empty']['value'])) {{ 'checked' }} @endif /> Партийность</label>
										</div>
									</div>
					
									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label"> <input type='checkbox' name='is_empty[]' value='party' @if (is_array(@$params['candidates']['filters']['is_empty']['value']) AND in_array('party', @$params['candidates']['filters']['is_empty']['value'])) {{ 'checked' }} @endif /> НЕ Член партии</label>
										</div>
									</div>
					
									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label"> <input type='checkbox' name='not_full_data' value='1' @if (@$params['candidates']['filters']['not_full_data']['value']) {{ 'checked' }} @endif /> НЕ полностью заполненные</label>
										</div>
									</div>
					
									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label"> <input type='checkbox' name='actual_elections_only' value='1' @if (@$params['candidates']['filters']['actual_elections_only']['value']) {{ 'checked' }} @endif /> Кроме архивных выборов</label>
										</div>
									</div>
					
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<button type="submit" name='action' value='setFilter' class="btn btn-primary">
									<i class="fa fa-save"></i> Установить
								</button>
								<button type="submit" name='action' value='resetFilter' class="btn btn-danger">
									<i class="fa fa-ban"></i> Сбросить
								</button>
							</div>
						</div>
					</form>
					<br/>
					
					<table class="table table-striped task-table">
						<thead>
							@foreach($showFields AS $key => $value)
								@if ($value['visible']) 
									<th><div>
											@if ($value['order_by'])
												<form action='/candidates' method='post'>
						
													{!! csrf_field() !!}
													
													<input type='hidden' name='action' value='orderBy' />
													<input type='hidden' name='field' value='{{ $value['field'] }}' />
														@if ($value['order_by']==$params['candidates']['order_by']['name'])
															@if ($params['candidates']['order_by']['type']=='asc')
																<span>{{ '&uarr;' }}</span>
															@else
																<span>{{ '&darr;' }}</span>
															@endif
														@endif
													<button type='submit' name='action' value='candidatesOrderBy' class='btn-link'>
														{{ $value['name'] }}
													</button>
												</form>
											@else {{ $value['name'] }} 
											@endif
									</div></th>
								@endif
							@endforeach

							<th><div>Операции</div></th>

						</thead>
						<tbody>
						@forelse($results AS $key => $value)
						<tr class="" >
							
							
							@foreach($showFields AS $key => $field)
								@if ($field['visible']) 
									@switch ($key)
										@case ('id')
											<td class="table-text">{{ $value->id }}</td>	
										@break
										@case ('fio')
											<td class="table-text">
												<a href='/candidates/{{ $value->id }}/view'>{{ $value->fio }}</a>
											</td>
										@break
										@case ('job')
											<td class="table-text">
												{{ $value->job }}
											</td>
										@break
										@case ('job_status')
											<td class="table-text">
												{{ $value->job_status }}
											</td>
										@break
										@case ('region')
											<td class="table-text">{{ $value->region->name }}</td>	
										@break
										@case ('email')
											<td class="table-text">{{ $value->email }}</td>	
										@break
										@case ('phone')
											<td class="table-text">{{ $value->phone }}</td>	
										@break
										@case ('party')
											<td class="table-text">
												@if ($value->party > 0) 
													<span class="glyphicon glyphicon-ok green" aria-hidden="true"></span>
												@endif
											</td>
										@break
										@case ('vip')
											<td class="table-text">
												@if ($value->vip > 0) 
													<span class="glyphicon glyphicon-ok green" aria-hidden="true"></span>
												@endif
											</td>
										@break
										@default
											<td class="table-text">
												<!-- Чтобы не прописывать кейсы для каждого из 66 полей -->
												@if ($field['id'] > 280)
													{{ $value->$field['field'] }}
												@endif
											</td>
										@break
									@endswitch
									
									
								@endif
							@endforeach

							<td>
								<a class="btn btn-success" href='/candidates/{{ $value->id }}/edit'>
									<i class="fa fa-edit"></i> Изменить
								</a>
							</td>

						</tr>
						@empty
						<tr>
							<td colspan="{{ count($showFields)+1 }}" class="table-text">
								<div class="warning">
									@if (@$params['candidates']['filters'])
										<h4>
											Не найдены кандидаты, соответствующие установленому вами фильтру: 
										</h4>
										<ul>
											@foreach($params['candidates']['filters'] AS $key => $value)
												@if ($value['active'])
													<li>
														{{ $value['name'] }} 
													</li>	
												@endif	
											@endforeach
										</ul>
										<hr/>
									@endif
								</div>
							</td>
						</tr>
						@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
