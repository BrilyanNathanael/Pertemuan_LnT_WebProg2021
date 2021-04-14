<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'genre_id' => $faker->numberBetween(1,10),
        'penulis' => $faker->name,
        'judul' => $faker->word,
        'deskripsi' => $faker->word,
        'image' => $faker->image('public/storage/images',640,480, null, false),
    ];
});
