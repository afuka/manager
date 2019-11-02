<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models as Model;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Model\User::class, function (Faker $faker) {
    return [
        'username' => $faker->userName,
        'nickname' => $faker->domainWord,
        'avatar' => $faker->imageUrl,
        'email' => $faker->safeEmail,
        'mobile' => $faker->unique()->phoneNumber,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'status' => '1',
    ];
});

$factory->define(Model\UsersInfo::class, function (Faker $faker, $user_id) {
    return [
        'user_id' => factory(Model\User::class)->create()->id,
        'name' => $faker->name,
        'id_no' => $faker->creditCardNumber,
        'gender' => 'unknown',
        'birthday' => $faker->date,
        'province' => '北京市',
        'city' => '北京市',
    ];
});