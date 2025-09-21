<?php

namespace Database\Factories\Users;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; //文字列関係の操作クラス
use App\Models\Users\User;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory {

    //◆モデルとの関係性定義
    protected $model = User::class;

    public function definition() {

        $faker = \Faker\Factory::create('ja_JP');

        //◇NOT NULLのカラムは入力必須
        return [
            'over_name' => $faker->lastName(),
            'under_name' => $faker->firstName(),
            'over_name_kana' => $faker->lastKanaName(),
            'under_name_kana' => $faker->firstKanaName(),

            'sex' => $faker->randomElement([1, 2, 3]),
            'birth_day' => $faker->date('Y-m-d', 'now'),
            'role' => $faker->randomElement([1, 2, 3, 4]),

            'mail_address' => $faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            //'remember_token' => Str::random(10),
        ];
    }
}
