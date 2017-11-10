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
		
		DB::table('users')->insert([
			'title' => 'Sr.',
			'fname' => 'Adan', 
			'lname' => 'Avilez Navarro', 
			'email' => 'adan.avilez@gmail.com', 
			'password' => bcrypt('sunvalley'),
			'is_admin' => 1, 
			'status' => 1
		]);
				
    }
}
