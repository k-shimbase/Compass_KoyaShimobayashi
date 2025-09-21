<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Users\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'over_name' => 'Ark',
            'under_name' => 'Night',
            'over_name_kana' => 'アーク',
            'under_name_kana' => 'ナイツ',
            'mail_address' => 'arknights@mail.com',
            'sex' => 1,
            'birth_day' => '2000-01-01',
            'role' => 1,
            'password' => Hash::make('password'),
            //'remember_token' => Str::random(10),
        ]);

        User::create([
            'over_name' => 'The',
            'under_name' => 'Carnival',
            'over_name_kana' => 'ザ',
            'under_name_kana' => 'カーニバル',
            'mail_address' => 'carnival@mail.com',
            'sex' => 1,
            'birth_day' => '2000-01-01',
            'role' => 4,
            'password' => Hash::make('password'),
            //'remember_token' => Str::random(10),
        ]);

        User::factory()->count(10)->create();
    }
}
