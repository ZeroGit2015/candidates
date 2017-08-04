@extends('layouts.app')

@section('content')
<div class="container logs">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
			
                <div class="panel-heading">
                	Журнал
                </div>

                <div class="panel-body">
					<div>
                       	@if (@$params['logs']['filters'])
                       		<h4>
								Установлен фильтр: 
							</h4>
							<ul>
								@foreach($params['logs']['filters'] AS $key => $value)
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
					<form class="form-horizontal" role="form" method='post' action='/logs'>
						{!! csrf_field() !!}
						<div class="row">
							<div class="col-sm-2">
								<label class="control-label">
									Ищем по 
								</label>
							</div>
							<div class="col-sm-2">
							
								<input type='radio' name='search' value='candidates.id' @if (!@$params['logs']['filters']['search'] or @$params['logs']['filters']['search']['value']=='candidates.id') {{ 'checked' }} @endif /> <label>id кандидата</label> 
								<br />
								<input type='radio' name='search' value='experts.id' @if (@$params['logs']['filters']['search']['value']=='experts.id') {{ 'checked' }} @endif /> <label>id эксперта</label> 
								<br />
								<input type='radio' name='search' value='all' @if (@$params['logs']['filters']['search']['value']=='all') {{ 'checked' }} @endif /> <label>любому полю</label> 
								
							</div>
							<div class="col-sm-5">
								<div class="form-group">
									<input type='text' name='value' class="form-control" value='{{ $params['logs']['filters']['value']['value'] or ''}}' />
								</div>	
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4">
                        		<label class="control-label">
                        			Пользователь
	                        	</label>
							</div>
							<div class="col-sm-5">
								<div class="form-group">
									<select name='id_user' class="form-control" >
										<option value=''></option>
										@foreach($users as $key => $value)
											<option value='{{ $value->id }}' @if ($value->id==@$params['logs']['filters']['id_user']['value']) {{ 'selected' }} @endif >
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
							<th>id</th>
							<th>Время создания</th>
							<th>Пользователь</th>
							<th>Тип</th>
							<th>id</th>
							<th>Ф.И.О.</th>
							<th>Информация</th>
						</thead>
						<tbody>
						@forelse($results AS $key => $value)
				    		<tr class="@if (!count($value->item_table())) red @endif">
								<td class="table-text">{{ $value->id }}</td>	
								<td class="table-text">{{ \App\Classes\A::to_dt_ru($value->created_at_3) }}</td>	
								<td class="table-text">@if (count($value->user)) {{ $value->user->name }} @endif</td>	
								<td class="table-text">{{ $value->name_table }}</td>	
								<td class="table-text">{{ $value->id_table }}</td>	
								<td class="table-text">@if (count($value->item_table())) <a href='/{{ $value->name_table }}/{{ $value->id_table }}/view'>{{ $value->item_table()->fio }}</a> @endif</td>	
								<td class="table-text">{!! nl2br($value->information) !!}</td>	
							</tr>
						@empty
							<tr>
								<td colspan="6" class="table-text">
									<div class="warning">НЕТ ДАННЫХ!</div>
								</td>
							</tr>
						@endforelse
						</tbody>
					</table>
					{{ $results->render() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
