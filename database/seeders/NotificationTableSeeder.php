<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NotificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(72);

        for($i = 0; $i <= 20; $i++){
            $user->notifications()->create([
                'id' => rand(1000, 999999),
                'type' => 'test notification',
                'data' => 'This is a test notification'
            ]);
        }
    }
}
