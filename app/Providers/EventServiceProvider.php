<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Log;
use App\Election;
use App\Election_Okrug;
use App\Activity;

use App\Candidate;
use App\Candidate_Comment;
use App\Candidate_Election;
use App\Candidate_Election_Okrug;
use App\Candidate_Activity;

use App\Expert;
use App\Expert_Activity;
use App\Expert_Href;

use Auth;
use Session;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //**************************************************************
        // Слушатели событий
        //**************************************************************

        //**************************************************************
        // Кандидаты
        //**************************************************************
		Candidate::saving(function($candidate) {
				if (isset($candidate->id)) {
					$information = "";
					$original = $candidate->getOriginal();
					$fields = $candidate->getFieldsList();
					foreach ($fields AS $key => $value) {

						if ($original[$value] != $candidate->$value) {
						    $fieldParams = $candidate->getFieldParams($value);
						    // Костыли для старого mysql
						    switch (TRUE) {
						    	// Тип Дата
						    	case strpos($fieldParams->Type, "date")!==FALSE:
						    		if (!($original[$value]=="0000-00-00" and $candidate->$value=="")) {
										$information .= ",{$value}({$fieldParams->Comment}): {$original[$value]}=>{$candidate->$value}\n";
						    		}
						    		break;
						    	// Тип Целый
						    	case strpos($fieldParams->Type, "int")!==FALSE:
						    		if (!($original[$value]=="0" and $candidate->$value=="")) {
										$information .= ",{$value}({$fieldParams->Comment}): {$original[$value]}=>{$candidate->$value}\n";
						    		}
						    		break;
						    	default:
									$information .= ",{$value}({$fieldParams->Comment}): {$original[$value]}=>{$candidate->$value}\n";
						    		break;

						    } // switch
						}
					}
					$information = $information ? "Изменены данные кандидата: ".substr($information, 1) : "";
				
					if ($information) {
						$log = new Log();
						$log->saveLog(Auth::user(), 'candidates', $information, $candidate->id);
					}
				}
		});

		Candidate::created(function($candidate) {
				$fields = $candidate->getFieldsList();
				$information = "";
				foreach ($fields AS $key => $value) {
					if ($candidate->$value) {
 				    	$fieldParams = $candidate->getFieldParams($value);
						$information .= ",{$value}({$fieldParams->Comment}): {$candidate->$value}\n";
					}
				}
				$information = $information ? "Кандидат добавлен: ".substr($information, 1) : "";
				
				if ($information) {
					$log = new Log();
					$log->saveLog(Auth::user(), 'candidates', $information, $candidate->id);
				}
		});

		Candidate::deleting(function($candidate) {
				$information = "Удален кандидат {$candidate->id} {$candidate->fio}";
				$log = new Log();
				$log->saveLog(Auth::user(), 'candidates', $information, $candidate->id);
		});


		// Выборы
		Candidate_Election::saving(function($candidate_election) {
				$election = Election::find($candidate_election->id_election);
				if (isset($candidate_election->id)) {
					$information = "";
					$original = $candidate_election->getOriginal();
					$fields = $candidate_election->getFieldsList();
					foreach ($fields AS $key => $value) {
						if ($original[$value] != $candidate_election->$value) {
						    $fieldParams = $candidate_election->getFieldParams($value);
							$information .= ",{$value}({$fieldParams->Comment}): {$original[$value]}=>{$candidate_election->$value}\n";
						}
					}
					$information = $information ? "Изменены данные выборов '{$election->election_name}': ".substr($information, 1) : "";
				} else {
					$information = "Добавлены выборы: ".$election->election_name."({$candidate_election->id_election})";
				}
				
				if ($information) {
					$log = new Log();
					$log->saveLog(Auth::user(), 'candidates', $information, $candidate_election->id_candidate);
				}
		});

		Candidate_Election::deleting(function($candidate_election) {
				$election = Election::find($candidate_election->id_election);
				$information = "Удалены выборы: ".$election->election_name."({$candidate_election->id_election})";
				$log = new Log();
				$log->saveLog(Auth::user(), 'candidates', $information, $candidate_election->id_candidate);
		});


		// Выборы. Округа 
		Candidate_Election_Okrug::created(function($candidate_election_okrug) {
				$information = "Добавлен округ: ".Election_Okrug::find($candidate_election_okrug->id_election_okrug)->name."({$candidate_election_okrug->id_election_okrug})";
				$log = new Log();
				$log->saveLog(Auth::user(), 'candidates', $information, $candidate_election_okrug->id_candidate);
		});

		Candidate_Election_Okrug::deleting(function($candidate_election_okrug) {
				$information = "Удален округ: ".Election_Okrug::find($candidate_election_okrug->id_election_okrug)->name."({$candidate_election_okrug->id_election_okrug})";
				$log = new Log();
				$log->saveLog(Auth::user(), 'candidates', $information, $candidate_election_okrug->id_candidate);
		});


		// Деятельность
		Candidate_Activity::created(function($candidate_activity) {
				$information = "Добавлена деятельность: ".Activity::find($candidate_activity->id_activity)->name."({$candidate_activity->id_activity})";
				$log = new Log();
				$log->saveLog(Auth::user(), 'candidates', $information, $candidate_activity->id_candidate);
		});

		Candidate_Activity::deleting(function($candidate_activity) {
				$information = "Удалена деятельность: ".Activity::find($candidate_activity->id_activity)->name."({$candidate_activity->id_activity})";
				$log = new Log();
				$log->saveLog(Auth::user(), 'candidates', $information, $candidate_activity->id_candidate);
		});


		// Комментарий
		Candidate_Comment::created(function($candidate_comment) {
				$information = "Добавлен комментарий: {$candidate_comment->comment}";
				$log = new Log();
				$log->saveLog(Auth::user(), 'candidates', $information, $candidate_comment->id_candidate);
		});

		
        //**************************************************************
		// Эксперты
        //**************************************************************
		Expert::saving(function($expert) {
				if (isset($expert->id)) {
					$information = "";
					$original = $expert->getOriginal();
					$fields = $expert->getFieldsList();
					foreach ($fields AS $key => $value) {
						if ($original[$value] != $expert->$value) {
						    $fieldParams = $expert->getFieldParams($value);
							$information .= ",{$value}({$fieldParams->Comment}): {$original[$value]}=>{$expert->$value}\n";
						}
					}
					$information = $information ? "Изменены данные эксперта: ".substr($information, 1) : "";
				
					if ($information) {
						$log = new Log();
						$log->saveLog(Auth::user(), 'experts', $information, $expert->id);
					}
				}
		});

		Expert::created(function($expert) {
				$fields = $expert->getFieldsList();
				$information = "";
				foreach ($fields AS $key => $value) {
					if ($expert->$value) {
					    $fieldParams = $expert->getFieldParams($value);
						$information .= ",{$value}({$fieldParams->Comment}): {$expert->$value}\n";
					}
				}
				$information = $information ? "Эксперт добавлен: ".substr($information, 1) : "";
				
				if ($information) {
					$log = new Log();
					$log->saveLog(Auth::user(), 'experts', $information, $expert->id);
				}
		});
	
		Expert::deleting(function($expert) {
				$information = "Удален эксперт {$expert->id} {$expert->fio}";
				$log = new Log();
				$log->saveLog(Auth::user(), 'experts', $information, $expert->id);
		});

		// Деятельность
		Expert_Activity::created(function($expert_activity) {
				$information = "Добавлена деятельность: ".Activity::find($expert_activity->id_activity)->name."({$expert_activity->id_activity})";
				$log = new Log();
				$log->saveLog(Auth::user(), 'experts', $information, $expert_activity->id_expert);
		});

		Expert_Activity::deleting(function($expert_activity) {
				$information = "Удалена деятельность: ".Activity::find($expert_activity->id_activity)->name."({$expert_activity->id_activity})";
				$log = new Log();
				$log->saveLog(Auth::user(), 'experts', $information, $expert_activity->id_expert);
		});

		// Ссылка
		Expert_Href::created(function($expert_href) {
				$information = "Добавлена ссылка: {$expert_href->title}";
				$log = new Log();
				$log->saveLog(Auth::user(), 'experts', $information, $expert_href->id_expert);
		});


    }
}
