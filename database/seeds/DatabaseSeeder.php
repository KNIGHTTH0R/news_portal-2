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
         $this->call([
             RoleTableSeeder::class,
             UserTableSeeder::class,
             UserRoleTableSeeder::class,
             CategoryTableSeeder::class,
         ]);

        factory(App\Models\Tag::class, 182)->create();
        factory(App\Models\News::class, 500)->create();

        $this->call([
            NewsTagTableSeeder::class
        ]);
    }
}
