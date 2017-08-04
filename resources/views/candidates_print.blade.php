@extends('layouts.print')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

			<div>
               	@if (@$params['filters'])
               		Установлен фильтр: 
					@foreach($params['filters'] AS $key => $value)
                		{{ $value['name'].$value['operation'].$value['value'] }}
					@endforeach
               		<br/>
               	@endif
			</div>



            <div class="panel panel-default">
                <div class="panel-heading">
                	Кандидаты
                </div>

                <div class="panel-body">
					<table class="table table-striped task-table">
						<thead>
							@foreach($showFields AS $key => $value)
								@if ($value['visible']) 
									<th>{{ $value['name'] }}</th> 
								@endif
							@endforeach

						</thead>
						<tbody>
						@forelse($results AS $key => $value)
				    	<tr class="
							@switch ($value->id_status)
								@case (1)
									orange
								@break
								@case (3)
									red
								@break
								@case (4)
									red
								@break
								@default
									@if ($value->id_status == 0)
									@else
										green
									@endif
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
											<td class="table-text"><a href='/candidates/{{ $value->id }}/view'>{{ $value->fio }}</a>
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
												<i class="fa fa-check green form-control"></i>
											@else
											@endif
											</td>
										@break
										@case ('vip')
											<td class="table-text">
											@if ($value->vip > 0) 
												<i class="fa fa-check green form-control"></i>
											@else
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
