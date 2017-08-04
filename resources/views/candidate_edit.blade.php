@extends('layouts.app')

@section('scripts')
	@parent
	<script src="{{asset('/scripts/modules/datepicker/js/bootstrap-datepicker.min.js')}}"></script>
	<script src="{{asset('/scripts/modules/datepicker/js/locales/bootstrap-datepicker.ru.min.js')}}"></script>
	<script src="{{asset('/scripts/modules/select/js/bootstrap-select.min.js')}}"></script>
	<script src="{{asset('/scripts/modules/select/js/i18n/defaults-ru_RU.js')}}"></script>
	<script src="{{asset('/scripts/functions.js')}}?v=1"></script>
	<script src="{{asset('/scripts/candidate_edit.js')}}?v=2"></script>

@stop
@section('styles')
	@parent
	<link href="{{asset('/scripts/modules/datepicker/css/bootstrap-datepicker.css')}}" rel="stylesheet">
	<link rel="stylesheet" href="{{asset('/scripts/modules/select/css/bootstrap-select.css')}}" />
@stop


@section('content')
<div class="container candidate_edit">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Кандидат</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method='POST' id='formCandidate' action='/candidates'>
						<input name='id' type='hidden' value='{{ old('fio', @$data->id) }}' />
						{!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('fio') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Ф.И.О</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="fio" value="{{ old('fio', @$data->fio) }}">

                                @if ($errors->has('fio'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fio') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('bdate') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Дата рождения</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control datepicker" data-provide="datepicker" name="bdate" value="{{ old('bdate', \App\Classes\A::to_dt_ru(@$data->bdate)) }}">

                                @if ($errors->has('bdate'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bdate') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Населенный пункт</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="city" value="{{ old('city', @$data->city) }}">

                                @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Адрес</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="address" value="{{ old('address', @$data->address) }}">

                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('id_region') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Регион</label>

                            <div class="col-md-6">
								<select name='id_region' class="form-control" >
									@foreach($regions as $key => $value)
										<option value='{{ $value->id }}' @if ($value->id==old('id_region', @$data->id_region)) {{ 'selected' }} @endif >
										 {{ $value->name }}
										</option>
									@endforeach
								</select>
                                @if ($errors->has('id_region'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('id_region') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('activity') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Выборы</label>

                            <div class="col-md-6">
                            	<div id='elections'>
                            		@if (@$data) 
										@foreach($data->elections() as $key => $value)
											@if ($value->id_election > 0)
												@include('election_edit', ['key'=>$key, 'election'=>$value, 'okrugs'=>$data->election_okrugs($value->id_election), 'statuses'=>$data->election_statuses($value->id_election)])
											@endif
										@endforeach
									@endif
								</div>
								<div class="row">
									<div class="col-md-10">
										<select name='election' data-live-search="true" class="form-control selectpicker" >
											<option value='' >
											@foreach($elections as $key => $value)
												<option value='{{ $value->id }}' >
												 {{ $value->election_name }}
												</option>
											@endforeach
										</select>
									</div>
									<div class="col-md-2">
										<a class='fa fa-plus election_add'></a>

										@if ($errors->has('election'))
											<span class="help-block">
												<strong>{{ $errors->first('election') }}</strong>
											</span>
										@endif
									</div>
								</div>
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('activity') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Деятельность</label>

                            <div class="col-md-6">
                            	<div id='activities'>
                            		@if (@$data) 
										@foreach($data->activities() as $key => $value)
											@if ($value->id_activity > 0)
												<div id='activity_{{ $value->id_activity }}' >{{ $value->name }} 
													<a id_activity='{{ $value->id_activity }}' class='fa fa-remove activity_del rigth'></a>
													<input type='hidden' name='candidate_activities[]' value='{{ $value->id_activity }}' />
												</div>
											@endif
										@endforeach
									@endif
								</div>
								<div class="row">
									<div class="col-md-10">
										<select name='activity' class="form-control" >
											<option value='' >
											@foreach($activities as $key => $value)
												<option value='{{ $value->id }}' >
												 {{ $value->name }}
												</option>
											@endforeach
										</select>
									</div>
									<div class="col-md-2">
										<a class='fa fa-plus activity_add'></a>

										@if ($errors->has('activity'))
											<span class="help-block">
												<strong>{{ $errors->first('activity') }}</strong>
											</span>
										@endif
									</div>
								</div>
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('party') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Партийность</label>

                            <div class="col-md-6">

                                <input type="checkbox" class="form-control" name="party" value="1" @if (old('party', @$data->party)) {{ "checked='checked'" }} @endif /> 
								
                                @if ($errors->has('party'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('party') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('vip') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">VIP</label>

                            <div class="col-md-6">

                                <input type="checkbox" class="form-control" name="vip" value="1" @if (old('vip', @$data->vip)) {{ "checked='checked'" }} @endif /> 
								
                                @if ($errors->has('vip'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('vip') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('job') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Работа</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="job" value="{{ old('job', @$data->job) }}"  />
                                @if ($errors->has('job'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('job') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('job_status') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Должность</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="job_status" value="{{ old('job_status', @$data->job_status) }}"  />
                                @if ($errors->has('job_status'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('job_status') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('invite') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Инициатор внесения</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="invite" value="{{ old('invite', @$data->invite) }}"  />

                                @if ($errors->has('invite'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('invite') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('vk_acc') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Аккаунт вКонтакте</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="vk_acc" value="{{ old('vk_acc', @$data->vk_acc) }}"  />

                                @if ($errors->has('vk_acc'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('vk_acc') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('fb_acc') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Аккаунт Facebook</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="fb_acc" value="{{ old('fb_acc', @$data->fb_acc) }}"  />

                                @if ($errors->has('fb_acc'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fb_acc') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
			
						<div class="form-group{{ $errors->has('ok_acc') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Аккаунт Одноклассники</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="ok_acc" value="{{ old('ok_acc', @$data->ok_acc) }}"  />

                                @if ($errors->has('ok_acc'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ok_acc') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('tw_acc') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Аккаунт Twitter</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="tw_acc" value="{{ old('tw_acc', @$data->tw_acc) }}"  />

                                @if ($errors->has('tw_acc'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tw_acc') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
		        		
		        		<div class="form-group{{ $errors->has('lj_acc') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Аккаунт LiveJournal</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="lj_acc" value="{{ old('lj_acc', @$data->lj_acc) }}"  />

                                @if ($errors->has('lj_acc'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lj_acc') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('inst_acc') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Аккаунт Instagram</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="inst_acc" value="{{ old('inst_acc', @$data->inst_acc) }}"  />

                                @if ($errors->has('inst_acc'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('inst_acc') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('per_acc') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Аккаунт Periscope</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="per_acc" value="{{ old('per_acc', @$data->per_acc) }}"  />

                                @if ($errors->has('per_acc'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('per_acc') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
			
						<div class="form-group{{ $errors->has('yt_acc') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Аккаунт YouTube</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="yt_acc" value="{{ old('yt_acc', @$data->yt_acc) }}"  />

                                @if ($errors->has('yt_acc'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('yt_acc') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
			
						<div class="form-group{{ $errors->has('personal_site') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Личный сайт</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="personal_site" value="{{ old('personal_site', @$data->personal_site) }}"  />

                                @if ($errors->has('personal_site'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('personal_site') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('wiki') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Википедия</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="wiki" value="{{ old('wiki', @$data->wiki) }}"  />

                                @if ($errors->has('wiki'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('wiki') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('information') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Справка</label>

                            <div class="col-md-6">
								<textarea type='text' class="form-control" name='information'>{{ old('information', @$data->information) }}</textarea>

                                @if ($errors->has('information'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('information') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Email</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="email" value="{{ old('email', @$data->email) }}"  />

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Телефон</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="phone" value="{{ old('phone', @$data->phone) }}"  />

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						

						<div class="panel panel-default">
							<div class="panel-heading ">
								<a data-toggle="collapse" href="#collapse1">Оценочная информация</a>
							</div>
							<div id="collapse1" class="panel-collapse collapse">
								<div class="panel-body">
								    УПС:
									<textarea type='text' class="form-control" name='ups'>{{ old('ups', @$data->ups) }}</textarea>
								    ЭАУ:
									<textarea type='text' class="form-control" name='auy'>{{ old('auy', @$data->auy) }}</textarea>
								    УРС:
									<textarea type='text' class="form-control" name='urs'>{{ old('urs', @$data->urs) }}</textarea>
								    УВ:
									<textarea type='text' class="form-control" name='uv'>{{ old('uv', @$data->uv) }}</textarea>
                        		</div>
                        	</div>
                        </div>
                        
                    	<div class="form-group save_button">
		                    <div class="text-center">
			                    <button type="submit" name='action' id='action' value='saveCandidate' class="btn btn-primary save_candidate">
				                    <i class="fa fa-save"></i> Сохранить
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
