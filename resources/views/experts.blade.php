@extends('layouts.app')

@section('content')
<div class="container experts">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default settings_panel">
				<div class="panel-heading ">
					<a data-toggle="collapse" href="#collapse1">Настройка</a>
					<div id="collapse1" class="panel-collapse collapse">
						<form class="form-horizontal" role="form" method='post' action='/experts'>

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
			
				<a class="btn btn-success pull-right" href='/experts/print' style='margin:3px' target='_blank'>
	              	<i class="fa fa-print"></i> Печатать
	   		    </a>
                <a class="btn btn-success pull-right " href='/experts/add' style='margin:3px'>
	              	<i class="fa fa-plus"></i> Добавить
   		        </a>
                <div class="panel-heading">
                	Эксперты
                </div>

                <div class="panel-body">
					<div>
                       	@if (@$params['experts']['filters'])
                       		<h4>
								Установлен фильтр: 
							</h4>
							<ul>
								@foreach($params['experts']['filters'] AS $key => $value)
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
					<form class="form-horizontal" role="form" method='post' action='/experts'>
						{!! csrf_field() !!}
						<div class="row">
							<div class="col-sm-1">
    	                    	<label class="control-label">
        	                		Регион
            	            	</label>
							</div>
							<div class="col-sm-5">
								<div class="form-group">
									<select name='id_region' class="form-control" >
										@foreach($regions as $key => $value)
											<option value='{{ $value->id }}' @if ($value->id==@$params['experts']['filters']['id_region']['value']) {{ 'selected' }} @endif >
												{{ $value->name }}
											</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2">
								<label class="control-label">
									Ищем по 
								</label>
							</div>
							<div class="col-sm-2">
							
								<input type='radio' name='search' value='fio' @if (!@$params['experts']['filters']['search']['value'] or @$params['experts']['filters']['search']['value']=='fio') {{ 'checked' }} @endif /> <label>Ф.И.О.</label> 
								<br />
								
								<input type='radio' name='search'  value='all' @if (@$params['experts']['filters']['search']['value']=='all') {{ 'checked' }} @endif /> <label>любому полю</label>
								
							</div>
							<div class="col-sm-7">
								<div class="form-group">
									<input type='text' name='value' class="form-control" value='{{ $params['experts']['filters']['value']['value'] or ''}}' />
								</div>	
							</div>
							<div class="col-sm-2">
                        		<label class="control-label">
                        			Деятельность
	                        	</label>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<select name='activity' class="form-control" >
										<option value=''></option>
										@foreach($activities as $key => $value)
											<option value='{{ $value->id }}' @if ($value->id==@$params['experts']['filters']['activity']['value']) {{ 'selected' }} @endif >
												{{ $value->name }}
											</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>

						<hr />

						<div class="col-sm-4">
							<button type="submit" name='action' value='setFilter' class="btn btn-primary">
								<i class="fa fa-save"></i> Установить
							</button>
							<button type="submit" name='action' value='resetFilter' class="btn btn-danger">
								<i class="fa fa-ban"></i> Сбросить
							</button>
						</div>
					</form>
					
					<table class="table table-striped task-table">
						<thead>
							@foreach($showFields AS $key => $value)
								@if ($value['visible']) 
									<th><div>
											@if ($value['order_by'])
												<form action='/experts' method='post'>
						
													{!! csrf_field() !!}
													
													<input type='hidden' name='action' value='orderBy' />
													<input type='hidden' name='field' value='{{ $value['field'] }}' />
														@if ($value['order_by']==$params['experts']['order_by']['name'])
															@if ($params['experts']['order_by']['type']=='asc')
																<span>{{ '&uarr;' }}</span>
															@else
																<span>{{ '&darr;' }}</span>
															@endif
														@endif
													<button type='submit' name='action' value='expertsOrderBy' class='btn-link'>
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
				    	<tr class="
							@switch ($value->id_status)
								@case ('0')
								@default
									green
								@break
							@endswitch
						" >
							
							
							@foreach($showFields AS $key => $field)
								@if ($field['visible']) 
									@switch ($key)
										@case ('id')
											<td class="table-text">{{ $value->id }}</td>	
										@break
										@case ('fio')
											<td class="table-text">
												<a href='/experts/{{ $value->id }}/view'>{{ $value->fio }}</a>
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
										@default
											<td class="table-text">{{ $value->$key }}</td>	
										@break
									@endswitch
									
								@endif
							@endforeach

							<td>
								<a class="btn btn-success" href='/experts/{{ $value->id }}/edit'>
									<i class="fa fa-edit"></i> Изменить
								</a>
							</td>

						</tr>
						@empty
						<tr>
							<td colspan="{{ count($showFields)+1 }}" class="table-text">
								<div class="warning">НЕТ ДАННЫХ!</div>
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
