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

        factory(App\Models\Tag::class, 24)->create();
        factory(App\Models\News::class, 6)->create();

        $this->call([
            NewsTagTableSeeder::class
        ]);
    }
}
