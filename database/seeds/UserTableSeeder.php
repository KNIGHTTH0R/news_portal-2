<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            'name' => 'admin',
            'email' => 'admin@a.a',
            'password' => bcrypt('000000'),
            'created_at' =>  \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('user')->insert([
            'name' => 'common1',
            'email' => 'common1@test.test',
            'password' => bcrypt('000000'),
            'created_at' =>  \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('user')->insert([
            'name' => 'common2',
            'email' => 'common2@test.test',
            'password' => bcrypt('000000'),
            'created_at' =>  \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
