<?php

use Illuminate\Database\Seeder;

class NewsTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 1000; $i++) {
            $array = $this->rand_diff();
            for($j = 0; $j < 3; $j++) {
                DB::table('news_tag')->insert([
                    'news_id' => $i,
                    'tag_id' => $array[$j],
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
            }
        }
    }

    /**
     * Generating array with three absolutely different numbers.
     * If one of the numbers is not unique,
     * function called again and again.
     *
     * @param array $array
     * @param int $length
     * @param int $max
     * @param int $min
     * @return array
     *
     */

    private function rand_diff(array $array = [], int $length = 3, int $max = 182, int $min = 1){

        for ($i = 0; $i < $length; $i++) {
            $array[] = rand($min, $max);
        }

        if (count(array_unique($array)) != 3){

            return $this->rand_diff();
        } else {

            return $array;
        }
    }
}
