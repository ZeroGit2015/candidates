@extends('layouts.app')

@section('content')
	<div class="container candidates">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-{{ $type }}">
					<div class="panel-heading">{{ $title }}</div>
					<div class="panel-body">{!! $message !!}</div>
				</div>
			</div>
		</div>
	</div>
@endsection
