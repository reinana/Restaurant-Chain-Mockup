<?php

namespace Helpers;

use Faker\Factory;

class RandomGenerator {
    
    // ランダムデータを取得する共通の関数、それぞれのコーラブルと数を受け取る
    public static function generate(callable $generatorFunction, int $min, int $max): array {
        $faker = Factory::create('ja_JP');
        $items = [];
        $numOfItems = $faker->numberBetween($min, $max);

        for ($i = 0; $i < $numOfItems; $i++) {
            $items[] = call_user_func($generatorFunction, $faker);
        }

        return $items;
    }

}
?>