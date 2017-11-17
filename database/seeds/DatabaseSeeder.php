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
        DB::table('role')->insert([
            'name' => 'admin',
            "created_at" =>  \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now(),
        ]);
        DB::table('role')->insert([
            'name' => 'common',
            'created_at' =>  \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('user')->insert([
            'name' => 'admin',
            'email' => 'admin@a.a',
            'password' => bcrypt('000000'),
            'created_at' =>  \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('user_role')->insert([
            'user_id' => 1,
            'role_id' => 1,
            'created_at' =>  \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('category')->insert([
            'name' => 'Политика',
            'slug' => str_slug('Политика'),
            'protected' => 1,
            'created_at' =>  \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('category')->insert([
            'name' => 'Спорт',
            'slug' => str_slug('Спорт'),
            'protected' => 0,
            'created_at' =>  \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);


    }
}
