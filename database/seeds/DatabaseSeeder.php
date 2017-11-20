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

        for ($i = 1; $i <= 4; $i++ ) {
            factory(App\Models\Advertisement::class, 1)->create([
                'block_position' => $i,
                'block_side' => 'left'
            ]);
        }

        for ($i = 1; $i <= 4; $i++ ) {
            factory(App\Models\Advertisement::class, 1)->create([
                'block_position' => $i,
                'block_side' => 'right'
            ]);
        }

        factory(App\Models\Tag::class, 182)->create();
        factory(App\Models\News::class, 1000)->create();

        $this->call([
            NewsTagTableSeeder::class
        ]);
    }
}
