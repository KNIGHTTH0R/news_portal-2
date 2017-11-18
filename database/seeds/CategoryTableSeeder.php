<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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

        DB::table('category')->insert([
            'name' => 'IT',
            'slug' => str_slug('IT'),
            'protected' => 0,
            'created_at' =>  \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('category')->insert([
            'name' => 'Наука',
            'slug' => str_slug('Наука'),
            'protected' => 0,
            'created_at' =>  \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
