@extends('layouts.app')

@section('scripts')
	@parent
	<script src="{{asset('/scripts/modules/select/js/bootstrap-select.min.js')}}"></script>
	<script src="{{asset('/scripts/modules/select/js/i18n/defaults-ru_RU.js')}}"></script>
@stop

@section('styles')
	@parent
	<link href="{{asset('/scripts/modules/datepicker/css/bootstrap-datepicker.css')}}" rel="stylesheet">
	<link rel="stylesheet" href="{{asset('/scripts/modules/select/css/bootstrap-select.css')}}" />
@stop

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Кандидат</div>
				<div class="panel-body">
					
					<form action="{{ url('candidates') }}" method="POST" class='form-inline'>
						<a class="btn btn-success" href='/candidates/{{ $data->id }}/edit'>
							<i class="fa fa-edit"></i> Изменить
						</a>

						<input type='hidden' name='id' value='{{ $data->id }}' />

						<button type="submit" class="btn btn-danger" onclick="return confirm('Удалить кандидата?');">
							<i class="fa fa-trash"></i> Удалить
						</button>
						<a class="btn btn-success" href='/candidates/{{ $data->id }}/log'>
							<i class="fa fa-book"></i> Журнал
						</a>
						<a class="btn btn-success" href='/candidates/{{ $data->id }}/print' target='_blank'>
							<i class="fa fa-print"></i> Печатать
						</a>
					</form>
					<hr/>

					<div class="table-responsive">
					    <table class="form-view table table-striped">
							@if ($data->fio)							
								<tr>
									<td class="font-label-view col-md-2">Ф.И.О</td>
					    
									<td class="col-md-10">
										<div>{{ $data->fio }}</div>
									</td>
								</tr>
							@endif
							
							@if (\App\Classes\A::to_dt_ru($data->bdate))							
								<tr>
									<td class="font-label-view col-md-2">Дата рождения</td>
					    
									<td class="col-md-10">
										<div>{{ \App\Classes\A::to_dt_ru($data->bdate) }}</div>
									</td>
								</tr>
							@endif
					    
							@if ($data->city)							
								<tr>
									<td class="font-label-view col-md-2">Населенный пункт</td>
					    
									<td class="col-md-10">
										<div>{{ $data->city }}</div>
									</td>
								</tr>
							@endif
					    
							@if ($data->address)							
								<tr>
									<td class="font-label-view col-md-2">Адрес</td>
					    
									<td class="col-md-10">
										<div>{{ $data->address }}</div>
									</td>
								</tr>
							@endif
					    
							@if ($regions[$data->id_region]->name)							
								<tr>
									<td class="font-label-view col-md-2">Регион</td>
					    
									<td class="col-md-10">
										<div>
												 {{ $regions[$data->id_region]->name }}
										</div>
									</td>
								</tr>
							@endif
								
							@if (count($data->elections()))
								<tr>
									<td colspan='2'>
										<div class="font-label-view col-md-2" style='padding-left:0px'>Выборы</div>
										<div id='elections col-md-10'>
											<div class="table-responsive">
											    <table class="table table-bordered table-striped">
													@foreach($data->elections() as $key => $value)
														@if ($value->id_election > 0)
															@include('election_view', ['key'=>$key, 'election'=>$value, 'okrugs'=>$data->election_okrugs($value->id_election), 'statuses'=>$data->election_statuses($value->id_election)])
														@endif
													@endforeach
												</table>
											</div>
										</div>
									</td>
								</tr>
							@endif
					    
								
							@if (count($data->activities()))							
								<tr>
									<td class="font-label-view col-md-2">Деятельность</td>
					    
									<td class="col-md-10">
										@foreach($data->activities() as $key => $value)
											<div id='activity_{{ $value->id_activity }}' >{{ $value->name }}</div>
										@endforeach
									</td>
								</tr>
							@endif
					    
								
							@if ($data->party)
								<tr>
									<td class="font-label-view col-md-2">Партийность</td>
					    
									<td class="col-md-10">
										<div>@if ($data->party) {{ "V" }} @endif</div> 
									</td>
								</tr>
							@endif
								
							@if ($data->vip)
								<tr>
									<td class="font-label-view col-md-2">VIP</td>
					    
									<td class="col-md-10">
										<div>@if ($data->vip) {{ "V" }} @endif</div> 
									</td>
								</tr>
							@endif
								
							@if ($data->job)
								<tr>
									<td class="font-label-view col-md-2">Работа</td>
					    
									<td class="col-md-10">
										<div>@if ($data->job) {{ "V" }} @endif</div> 
									</td>
								</tr>
							@endif
								
							@if ($data->job_status)
								<tr>
									<td class="font-label-view col-md-2">Должность</td>
					    
									<td class="col-md-10">
										<div>{{ $data->job_status }}</div>
									</td>
								</tr>
							@endif
								
							@if ($data->invite)
								<tr>
									<td class="font-label-view col-md-2">Инициатор внесения</td>
					    
									<td class="col-md-10">
										<div>{{ $data->invite }}</div>
									</td>
								</tr>
							@endif
					    
							@if ($data->vk_acc or $data->fb_acc or $data->tw_acc or $data->lj_acc or $data->inst_acc or $data->per_acc or $data->yt_acc)
								<tr>
									<td class="font-label-view col-md-2">Социальные сети</td>
					    
									<td class="col-md-10 social_net">
									
										@if ($data->vk_acc)
											<a href="{{ $data->vk_acc or old('vk_acc') }}" class="sn_vk" /> </a>
										@endif
										@if ($data->fb_acc)
											<a href="{{ $data->fb_acc or old('fb_acc') }}"  class="sn_fb"  /> </a>
										@endif
										@if ($data->ok_acc)
											<a href="{{ $data->ok_acc or old('ok_acc') }}"  class="sn_ok"  /> </a>
										@endif
										@if ($data->tw_acc)
											<a href="{{ $data->tw_acc or old('tw_acc') }}"  class="sn_tw"  /> </a>
										@endif
										@if ($data->lj_acc)
											<a href="{{ $data->lj_acc or old('lj_acc') }}"  class="sn_lj"  /> </a>
										@endif
										@if ($data->inst_acc)
											<a href="{{ $data->inst_acc or old('inst_acc') }}"  class="sn_inst"  /> </a>
										@endif
										@if ($data->per_acc)
											<a href="{{ $data->per_acc or old('per_acc') }}"  class="sn_per"  /> </a>
										@endif
										@if ($data->yt_acc)
											<a href="{{ $data->yt_acc or old('yt_acc') }}"  class="sn_yt"  /> </a>
										@endif
					    
									</td>
								</tr>
							@endif					
					    
							@if ($data->personal_site)
								<tr>
									<td class="font-label-view col-md-2">Личный сайт</td>
					    
									<td class="col-md-10">
										<div>{{ $data->personal_site }}</div>
									</td>
								</tr>
							@endif					
								
							@if ($data->wiki)
								<tr>
									<td class="font-label-view col-md-2">Википедия</td>
					    
									<td class="col-md-10">
										<div>{{ $data->wiki }}</div>
									</td>
								</tr>
							@endif					
					    
							@if ($data->information)
								<tr>
									<td class="font-label-view col-md-2">Справка</td>
					    
									<td class="col-md-10">
										<div>{!! nl2br($data->information) !!}</div>
									</td>
								</tr>
							@endif					
								
							@if ($data->email)
								<tr>
									<td class="font-label-view col-md-2">Email</td>
					    
									<td class="col-md-10">
										<div>{{ $data->email }}</div>
									</td>
								</tr>
							@endif					
								
							@if ($data->phone)
								<tr>
									<td class="font-label-view col-md-2">Телефон</td>
					    
									<td class="col-md-10">
										<div>{{ $data->phone }}</div>
									</td>
								</tr>
							@endif					
						</table>

							
						@if ($data->ups or $data->auy or $data->urs or $data->uv)
							<div class="panel panel-default">
								<div class="panel-heading ">
									<a data-toggle="collapse" href="#collapse1">Оценочная информация</a>
								</div>
								<div id="collapse1" class="panel-collapse collapse">
									<div class="panel-body">
					                    <table class="form-view table-striped">
											@if ($data->ups)							
												<tr>
													<td class="font-label-view col-md-2">УПС</td>
					                    
													<td class="col-md-10">
														<div>{!! nl2br($data->ups) !!}</div>
													</td>
												</tr>
											@endif
											@if ($data->auy)							
												<tr>
													<td class="font-label-view col-md-2">ЭАУ</td>
					                    
													<td class="col-md-10">
														<div>{!! nl2br($data->auy) !!}</div>
													</td>
												</tr>
											@endif
											@if ($data->urs)							
												<tr>
													<td class="font-label-view col-md-2">УРС</td>
					                    
													<td class="col-md-10">
														<div>{!! nl2br($data->urs) !!}</div>
													</td>
												</tr>
											@endif
											@if ($data->uv)							
												<tr>
													<td class="font-label-view col-md-2">УВ</td>
					                    
													<td class="col-md-10">
														<div>{!! nl2br($data->uv) !!}</div>
													</td>
												</tr>
											@endif
										</table>
									</div>
								</div>
							</div>
						@endif					
					</div>

					<hr/>	

					<form action="{{ url('candidates') }}" method="POST" class='form-inline'>
						{!! csrf_field() !!}
						{!! method_field('DELETE') !!}
					
						<a class="btn btn-success" href='/candidates/{{ $data->id }}/edit'>
							<i class="fa fa-edit"></i> Изменить
						</a>

						<input type='hidden' name='id' value='{{ $data->id }}' />

						<button type="submit" class="btn btn-danger" onclick="return confirm('Удалить кандидата?');">
							<i class="fa fa-trash"></i> Удалить
						</button>
						<a class="btn btn-success" href='/candidates/{{ $data->id }}/log'>
							<i class="fa fa-book"></i> Журнал
						</a>
						<a class="btn btn-success" href='/candidates/{{ $data->id }}/print' target='_blank'>
							<i class="fa fa-print"></i> Печатать
						</a>
					</form>

					{{-- Комментарии --}}
					@foreach($data->comments as $key => $value)
						<hr/>
						<table>
							<tr>
								<td align='left'>
									{{ \App\Classes\A::to_dt_ru($value->created_at) }} {{ $value->user->name }}
								</td>
							</tr>
							<tr>
								<td>
									{{ $value->comment }}
								</td>
							</tr>
						</table>
					@endforeach

					<hr/>

					<form method='POST' class='form-inline' role='form' action='/candidates'>	
						{!! csrf_field() !!}

						<input name='id' value='' type='hidden' />
						<input name='id_candidate' value='{{ $data->id }}' type='hidden' />

						<div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}" >
								<textarea type='text' placeholder="Комментарий" class="form-control" name='comment' cols='110'></textarea>
	   					</div>
	   					<div style='top:0;float:right;'>
		   					<div class='form-group'>
								<button type="submit" name='action' value='saveComment' class="btn btn-success" >
									<i class="fa fa-plus"></i> Добавить
								</button>
							</div>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
