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
            'role_id' => 1,
            'name' => 'Mr. Admin',
            'username' => 'Admin',
            'email' => 'admin@blog.com',
            'password' => bcrypt('1234'),

        ]);

        DB::table('users')->insert([
            'role_id' => 2,
            'name' => 'Mr. Author',
            'username' => 'Author',
            'email' => 'author@blog.com',
            'password' => bcrypt('1234'),

        ]);

    }
}
