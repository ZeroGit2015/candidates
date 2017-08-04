@extends('layouts.print')

<div class="container candidate_print">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Кандидат</div>
                <div class="panel-body">

						<table class="default_fields">
						
							<tr class="form-group">
								<td class="col-md-4 control-td">Ф.И.О</td>

								<td class="col-md-6">
									<div class="form-control" name="fio" value="" disabled >{{ $data->fio }}</div>
								</td>
							</tr>
						
							<tr class="form-group">
								<td class="col-md-4 control-td">Дата рождения</td>

								<td class="col-md-6">
									<div class="form-control" name="bdate" value="" disabled >{{ \App\Classes\A::to_dt_ru(@$data->bdate) }}</div>
								</td>
							</tr>

							<tr class="form-group">
								<td class="col-md-4 control-td">Населенный пункт</td>

								<td class="col-md-6">
									<div class="form-control" name="city" value="" disabled >{{ $data->city }}</div>
								</td>
							</tr>

							<tr class="form-group">
								<td class="col-md-4 control-td">Адрес</td>

								<td class="col-md-6">
									<div class="form-control" name="address" value="" disabled >{{ $data->address }}</div>
								</td>
							</tr>

							<tr class="form-group">
								<td class="col-md-4 control-td">Регион</td>

								<td class="col-md-6">
									@foreach($regions as $key => $value)
										@if ($value->id==$data->id_region) <div class="form-control">{{ $value->name }}</div> @endif 
									@endforeach
								</td>
							</tr>
							
							<tr class="form-group">
								<td class="col-md-4 control-td">Партийность</td>

								<td class="col-md-6">
								
									@if ($data->party) 
										<i class="fa fa-check green form-control"></i>
									@endif
									
								</td>
							</tr>
							
							<tr class="form-group">
								<td class="col-md-4 control-td">VIP</td>

								<td class="col-md-6">
								
									@if ($data->vip) 
										<i class="fa fa-check green form-control"></i>
									@endif
									
								</td>
							</tr>
							
							<tr class="form-group">
								<td class="col-md-4 control-td">Работа</td>

								<td class="col-md-6">
									<div class="form-control">{{ $data->job }}</div>
								</td>
							</tr>
							
							<tr class="form-group">
								<td class="col-md-4 control-td">Должность</td>

								<td class="col-md-6">
									<div class="form-control">{{ $data->job_status }}</div>
								</td>
							</tr>
							
							<tr class="form-group">
								<td class="col-md-4 control-td">Инициатор внесения</td>

								<td class="col-md-6">
									<div class="form-control">{{ $data->invite }}</div>
								</td>
							</tr>
							
							<tr class="form-group">
								<td class="col-md-4 control-td">Аккаунт вКонтакте</td>

								<td class="col-md-6">
									<div class="form-control">{{ $data->vk_acc }}</div>
								</td>
							</tr>
							
							<tr class="form-group">
								<td class="col-md-4 control-td">Аккаунт Facebook</td>

								<td class="col-md-6">
									<div class="form-control">{{ $data->fb_acc }}</div>
								</td>
							</tr>
				
							<tr class="form-group">
								<td class="col-md-4 control-td">Аккаунт Одноклассники</td>

								<td class="col-md-6">
									<div class="form-control">{{ $data->ok_acc }}</div>
								</td>
							</tr>
							
							<tr class="form-group">
								<td class="col-md-4 control-td">Аккаунт Twitter</td>

								<td class="col-md-6">
									<div class="form-control">{{ $data->tw_acc }}</div>
								</td>
							</tr>
							
							<tr class="form-group">
								<td class="col-md-4 control-td">Аккаунт LiveJournal</td>

								<td class="col-md-6">
									<div class="form-control">{{ $data->lj_acc }}</div>
								</td>
							</tr>
							
							<tr class="form-group">
								<td class="col-md-4 control-td">Аккаунт Instagram</td>

								<td class="col-md-6">
									<div class="form-control">{{ $data->inst_acc }}</div>
								</td>
							</tr>
							
							<tr class="form-group">
								<td class="col-md-4 control-td">Аккаунт Periscope</td>

								<td class="col-md-6">
									<div class="form-control">{{ $data->per_acc }}</div>
								</td>
							</tr>
				
							<tr class="form-group">
								<td class="col-md-4 control-td">Аккаунт YouTube</td>

								<td class="col-md-6">
									<div class="form-control">{{ $data->yt_acc }}</div>
								</td>
							</tr>
				
							<tr class="form-group">
								<td class="col-md-4 control-td">Личный сайт</td>

								<td class="col-md-6">
									<div class="form-control">{{ $data->personal_site }}</div>
								</td>
							</tr>
							
							<tr class="form-group">
								<td class="col-md-4 control-td">Википедия</td>

								<td class="col-md-6">
									<div class="form-control">{{ $data->wiki }}</div>
								</td>
							</tr>

							<tr class="form-group">
								<td class="col-md-4 control-td">Справка</td>

								<td class="col-md-6">
									<div class="form-control">{!! nl2br($data->information) !!}</div>
								</td>
							</tr>
							
							<tr class="form-group">
								<td class="col-md-4 control-td">Email</td>

								<td class="col-md-6">
									<div class="form-control">{{ $data->email }}</div>
								</td>
							</tr>
							
							<tr class="form-group">
								<td class="col-md-4 control-td">Телефон</td>

								<td class="col-md-6">
									<div class="form-control">{{ $data->phone }}</div>
								</td>
							</tr>

							<tr class="form-group">
								<td class="col-md-4 control-td">УПС:</td>

								<td class="col-md-6">
									<div class="form-control">{!! nl2br($data->ups) !!}</div>
								</td>
							</tr>

							<tr class="form-group">
								<td class="col-md-4 control-td">ЭАУ:</td>

								<td class="col-md-6">
									<div class="form-control">{!! nl2br($data->auy) !!}</div>
								</td>
							</tr>

							<tr class="form-group">
								<td class="col-md-4 control-td">УРС:</td>

								<td class="col-md-6">
									<div class="form-control">{!! nl2br($data->urs) !!}</div>
								</td>
							</tr>

							<tr class="form-group">
								<td class="col-md-4 control-td">УВ:</td>

								<td class="col-md-6">
									<div class="form-control">{!! nl2br($data->uv) !!}</div>
								</td>
							</tr>
						</table>
                </div>
            </div>
        </div>
    </div>
</div>
@section('content')
@endsection
