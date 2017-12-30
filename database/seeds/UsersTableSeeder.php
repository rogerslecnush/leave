<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class)->times(10)->create();

        for ($i = 1; $i <= 10; $i++) {
            DB::table("team_user")->insert([
                "user_id" => $i,
                "team_id" => rand(1,2)
            ]);
        }
    }
}
