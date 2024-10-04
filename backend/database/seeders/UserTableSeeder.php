<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\Auth\RegisterationService;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $users = [
        //     [
        //         'first_name' => 'Sudo',
        //         'email' => 'admin@maihomm.com',
        //         'password' => 'Sudo*@34249',
        //     ],
        // ];

        // foreach ($users as $key => $user) {
        //     RegisterationService::createUser($user);
        // }


        $data =   [
            'first_name' => 'Admin',
            'email' => 'admin@maihomm.com',
            'password' => Hash::make('Sudo*@34249'),
            'role' => "Admin",
            'ref_code' => RegisterationService::generateRefCode()
        ];
        User::create($data);
    }
}
