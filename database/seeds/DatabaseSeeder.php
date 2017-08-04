<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(CandidateTableSeeder::class);
        $this->call(Candidate_CommentTableSeeder::class);
        $this->call(ElectionTableSeeder::class);
        $this->call(ElectionOkrugTableSeeder::class);
    }
}
