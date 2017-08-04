<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Log;

class LogsController extends Controller
{
    // �������
    public function getIndex(Log $log, User $user)
    {
			$results = $log->getAll();
	        return view('logs')->with(["results"=>$results, 'params'=>$user->getParams(), 'users'=>$user->getAll()->get()]);
    	
    }

    // ��������� post ��������(����������-���������)
    public function postIndex(Log $log, Request $request)
    {
    	
    	switch ($request->input('action')) {
    		// ��������� �������
    		case 'setFilter':
    			$log->setFilter($request);
				return redirect("/logs");
    			break;
    		// ����� �������
    		case 'resetFilter':
    			$log->setFilter();
				return redirect("/logs");
    			break;
    	}
    }

}
