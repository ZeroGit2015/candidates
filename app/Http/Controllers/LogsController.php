<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Log;

class LogsController extends Controller
{
    // Таблица
    public function getIndex(Log $log, User $user)
    {
			$results = $log->getAll();
	        return view('logs')->with(["results"=>$results, 'params'=>$user->getParams(), 'users'=>$user->getAll()->get()]);
    	
    }

    // Обработка post запросов(добавление-изменение)
    public function postIndex(Log $log, Request $request)
    {
    	
    	switch ($request->input('action')) {
    		// Установка фильтра
    		case 'setFilter':
    			$log->setFilter($request);
				return redirect("/logs");
    			break;
    		// Сброс фильтра
    		case 'resetFilter':
    			$log->setFilter();
				return redirect("/logs");
    			break;
    	}
    }

}
