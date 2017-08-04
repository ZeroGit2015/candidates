{{-- Шаблон вывода выборов в форме просмотра кандидата --}}
<tr>
	<td>
		<div id='election_{{ $election->id_election }}'>
			<h4><strong>{{ $election->election_name }}</strong></h4>
			@if ($election->have_okrugs)
				<div style='margin:5px;'>
					Округ:
					<div>
						@foreach($okrugs as $key => $value)
							@if ($value['selected']) <div>{{ $value['name'] }}</div> @endif
						@endforeach
					</div>
				</div>
			@endif
			<input type='hidden' name='candidate_elections[{{ $election->id_election }}][id_election]' value='{{ $election->id_election }}' disabled />
			<div style='margin:5px;'>
				Статус: 
				<div>
					@foreach($statuses as $key => $value)
						@if ($value['selected']) <div>{{ $value['name'] }}</div> @endif
					@endforeach
        		</div>
		
			</div>
			<div style='margin:5px;'>
				Позиция в списке: <div>{{ $election->list_position }}</div>
			</div>
			<div style='margin:5px;'>
				Ответственный за ведение переговоров от Яблока: <div>{{ $election->speaker }}</div>
			</div>
			<div style='margin:5px;'>
				Информация о ходе переговоров: <div>{!! nl2br($election->speaker_info) !!}</div>
			</div>
			<div style='margin:5px;'>
				Итог переговоров: <div>{!! nl2br($election->speaker_itog) !!}</div>
			</div>
		</div>
	</td>
</tr>