<?php

use Illuminate\Database\Seeder;

class UsersTabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'Budi Irawan',
            'username' => 'irawanalkarim',
            'password' => bcrypt('password'),
            'email' => 'irawanalkarim@gmail.com'
        ]);
    }
}
