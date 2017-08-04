@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Эксперт</div>
                <div class="panel-body">

                    <form method='POST' class="form-horizontal" role="form" action='/experts'>

						<input name='id' type='hidden' value='{{ old('fio', @$data->id) }}' />
						{!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('fio') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Ф.И.О</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="fio" value="{{ old('fio', @$data->fio) }}" disabled='disabled' />

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
                                <input type="text" class="form-control" name="bdate" value="{{ old('bdate', \App\Classes\A::to_dt_ru(@$data->bdate)) }}" disabled='disabled' >

                                @if ($errors->has('bdate'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bdate') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('id_status') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Статус</label>

                            <div class="col-md-6">
								<select name='id_status' class="form-control" disabled='disabled' >
									@foreach($statuses as $key => $value)
										<option value='{{ $value->id }}' @if ($value->id==old('id_status', @$data->id_status)) {{ 'selected' }} @endif >
										 {{ $value->name }}
										</option>
									@endforeach
								</select>
                                @if ($errors->has('id_status'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('id_status') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('id_region') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Регион</label>

                            <div class="col-md-6">
								<select name='id_region' class="form-control" disabled='disabled' >
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
                            <label class="col-md-4 control-label">Деятельность</label>

                            <div class="col-md-6">

								@foreach($data->activities() as $key => $value)
									<div id='activity_{{ $value->id_activity }}' >{{ $value->name }}</div>
								@endforeach

                                @if ($errors->has('activity'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('activity') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        

                        <div class="form-group{{ $errors->has('job') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Работа</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="job" value="{{ old('job', @$data->job) }}" disabled='disabled' />
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
                                <input type="text" class="form-control" name="job_status" value="{{ old('job_status', @$data->job_status) }}" disabled='disabled' />
                                @if ($errors->has('job_status'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('job_status') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
						<div class="form-group{{ $errors->has('web_organizations') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Веб организации</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="web_organizations" value="{{ old('web_organizations', @$data->web_organizations) }}"  disabled='disabled' />

                                @if ($errors->has('web_organizations'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('web_organizations') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        
						<div class="form-group{{ $errors->has('vk_acc') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Социальные сети</label>

                            <div class="col-md-6 social_net">
							
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

                            </div>
                        </div>
			
						<div class="form-group{{ $errors->has('personal_site') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Личный сайт</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="personal_site" value="{{ old('personal_site', @$data->personal_site) }}" disabled='disabled' />

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
                                <input type="text" class="form-control" name="wiki" value="{{ old('wiki', @$data->wiki) }}" disabled='disabled' />

                                @if ($errors->has('wiki'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('wiki') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

						<div class="form-group{{ $errors->has('post_index') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Почтовый индекс</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="post_index" value="{{ old('post_index', @$data->post_index) }}"  disabled='disabled' />

                                @if ($errors->has('post_index'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('post_index') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


						<div class="form-group{{ $errors->has('post_address') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Почтовый адрес</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="post_address" value="{{ old('post_address', @$data->post_address) }}"  disabled='disabled' />

                                @if ($errors->has('post_address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('post_address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('information') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Справка</label>

                            <div class="col-md-6">
								<textarea type='text' class="form-control" name='information' disabled='disabled' >{{ old('wiki', @$data->information) }}</textarea>

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
                                <input type="text" class="form-control" name="email" value="{{ old('wiki', @$data->email) }}" disabled='disabled' />

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
                                <input type="text" class="form-control" name="phone" value="{{ old('phone', @$data->phone) }}" disabled='disabled' />

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('speaker_info') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Информация о ходе переговоров</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="speaker_info" value="{{ old('speaker_info', @$data->speaker_info) }}" disabled='disabled' />

                                @if ($errors->has('speaker_info'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('speaker_info') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
                        <div class="form-group{{ $errors->has('notice') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Примечание</label>

                            <div class="col-md-6">
								<textarea type='text' class="form-control" name='notice' disabled='disabled' >{{ old('notice', @$data->notice) }}</textarea>
                                @if ($errors->has('notice'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('notice') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </form>

                    <form action="{{ url('experts') }}" method="POST" class='form-inline'>
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                    
						<a class="btn btn-success" href='/experts/{{ $data->id }}/edit'>
							<i class="fa fa-edit"></i> Изменить
						</a>

                        <input type='hidden' name='id' value='{{ $data->id }}' />

                        <button type="submit" class="btn btn-danger" onclick="return confirm('Удалить эксперта?');">
                            <i class="fa fa-trash"></i> Удалить
                        </button>
						<a class="btn btn-success" href='/experts/{{ $data->id }}/log'>
							<i class="fa fa-book"></i> Журнал
						</a>
						<a class="btn btn-success" href='/experts/{{ $data->id }}/print' target='_blank'>
							<i class="fa fa-print"></i> Печатать
						</a>
                    </form>

					{{-- Ссылки на материалы --}}
					@foreach($data->hrefs as $key => $value)
						<hr/>
						<table>
							<tr>
								<td align='left'>
									{{ \App\Classes\A::to_dt_ru($value->created_at) }} {{ $value->user->name }}

									@if ($value->href) 
										<a href='{{ $value->href }}'>Ссылка</a>
									@endif
								</td>
							</tr>
							<tr>
								<td>
									{{ $value->title }}
								</td>
							</tr>
						</table>
					@endforeach

					<hr/>
					<form method='POST' class='form-horizontal' role='form' action='/experts'>	
						{!! csrf_field() !!}

						<input name='id' value='' type='hidden' />
						<input name='id_expert' value='{{ $data->id }}' type='hidden' />

	                    <div class="form-group{{ $errors->has('href') ? ' has-error' : '' }}" >
                            <div class="col-md-6">
								<label>Ссылка:</label> <input class="form-control" name='href' type='text' />
    	    		            @if ($errors->has('href'))
        	    		            <span class="help-block">
            	    		            <strong>{{ $errors->first('href') }}</strong>
	            	                </span>
		            	        @endif
		            	    </div>
	   	                </div>

	                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}" >
                            <div class="col-md-6">
								<label>Материал:</label> <textarea type='text' placeholder="" class="form-control" name='title' cols='110'></textarea>
    	    		            @if ($errors->has('title'))
        	    		            <span class="help-block">
            	    		            <strong>{{ $errors->first('title') }}</strong>
	            	                </span>
		            	        @endif
		            	    </div>
	   	                </div>

	   	                <div class='form-group'>
                            <div class="col-md-6">
								<button type="submit" name='action' value='saveHref' class="btn btn-success" >
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
