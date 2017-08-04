@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Главная страница</div>

                <div class="panel-body">
    	                <a class='btn btn-default' href="{{ url('/candidates') }}">Кандидаты</a>
    	                <a class='btn btn-default' href="{{ url('/experts') }}">Эксперты</a>
    	                <a class='btn btn-default' href="{{ url('/logs') }}">Журнал</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
