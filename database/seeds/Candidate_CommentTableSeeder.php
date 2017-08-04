<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Candidate_Comment;

class Candidate_CommentTableSeeder extends Seeder {

	public function run()
	{
			DB::table('candidate_comments')->truncate();

			Candidate_Comment::create([
 				'id_user'		=> '1',
 				'id_candidate'	=> '1',
 				'comment'		=> 'Комментарий 1',
 			]);
		
			Candidate_Comment::create([
 				'id_user'		=> '1',
 				'id_candidate'	=> '1',
 				'comment'		=> 'Комментарий 2',
 			]);
		
		
	}

}