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
        DB::table('users')->insert([
            'name' => 'Marilyn',
            'surname' => 'García',
            'email' => 'marilyn_gm@outlook.com',
            'password' => bcrypt('demo'),
            'isAdmin' => true,
            'isCook' => false,
            'isFront' => false
        ]);
    }
}
