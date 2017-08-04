{{-- Шаблон вывода выборов в форме редактирования кандидата --}}
<div id='election_{{ $election->id_election }}'>
	{{ $election->election_name }}
	<a id_election='{{ $election->id_election }}' class='fa fa-remove election_del'></a>
	@if ($election->have_okrugs)
		<div style='margin:5px;'>
			Округ:
			<select name='candidate_election_okrugs[{{ $election->id_election }}][]'  class='selectpicker' multiple='multiple'>
				@foreach($okrugs as $key => $value)
					<option value='{{ $value['id'] }}' {{ $value['selected'] }}>{{ $value['name'] }}</option>
				@endforeach
			</select>
		</div>
	@endif
	<input type='hidden' name='candidate_elections[{{ $election->id_election }}][id_election]' value='{{ $election->id_election }}' />
	<div style='margin:5px;'>
		Статус: 
		<select name='candidate_elections[{{ $election->id_election }}][id_status]'  class='selectpicker'>
			<option value='0'></option>
			@foreach($statuses as $key => $value)
				<option value='{{ $value['id'] }}' {{ $value['selected'] }}>{{ $value['name'] }}</option>
			@endforeach
		</select>

	</div>
	<div style='margin:5px;'>
		Позиция в списке: <input type='text' class="form-control" name='candidate_elections[{{ $election->id_election }}][list_position]' value='{{ $election->list_position }}' />
	</div>
	<div style='margin:5px;'>
		Ответственный за ведение переговоров от Яблока: <input type='text' class="form-control" name='candidate_elections[{{ $election->id_election }}][speaker]' value='{{ $election->speaker }}' />
	</div>
	<div style='margin:5px;'>
		Информация о ходе переговоров: <textarea type='text' class="form-control" name='candidate_elections[{{ $election->id_election }}][speaker_info]'>{{ $election->speaker_info }}</textarea>
	</div>
	<div style='margin:5px;'>
		Итог переговоров: <textarea type='text' class="form-control" name='candidate_elections[{{ $election->id_election }}][speaker_itog]'>{{ $election->speaker_itog }}</textarea>
	</div>
	<hr/>
</div>