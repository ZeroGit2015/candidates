@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                	Журнал изменений по эксперту: <a href='/experts/{{ $data->id }}/view'>{{ $data->fio }}</a>
                </div>

                <div class="panel-body">
					<table class="table table-striped task-table">
						<thead>
							<th>id</th>
							<th>Время создания</th>
							<th>Пользователь</th>
							<th>Информация</th>
						</thead>
						<tbody>
						@forelse($data->log() AS $key => $value)
				    	<tr>
							<td class="table-text">{{ $value->id }}</td>	
							<td class="table-text">{{ \App\Classes\A::to_dt_ru($value->created_at_3) }}</td>	
							<td class="table-text">@if (count($value->user)) {{ $value->user->name }} @endif</td>	
							<td class="table-text">{!! nl2br($value->information) !!}</td>	
						</tr>
						@empty
						<tr>
							<td colspan="3" class="table-text">
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
