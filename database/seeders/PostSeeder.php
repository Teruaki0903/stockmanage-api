<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('posts')->insert([
                'name' => $faker->word,           // 'name' は名前を生成
                'amount' => $faker->numberBetween(10, 100), // 'amount' はランダムな整数を生成
                'price' => $faker->numberBetween(100, 1000), // 'price' は100から1000の間のランダムな数値を生成
            ]);
        }
    }
}