<?php

namespace Database\Seeders;

use App\Models\KycVerification;
use App\Models\Payment;
use App\Models\PaymentFile;
use App\Models\Portfolio;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DataMigrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data =   [
            'avatar_id' => '203',
            'first_name' => 'Patricia',
            'last_name' => 'Duru',
            'email' => 'patricia.duru@gmail.com',
            'password' => Hash::make('password'),
            'role' => "User",
            'phone_no' => '08147203163',
            'date_of_birth' => '17-02-1980',
            'ref_code' => 'lPWomRF8',
            'status' => 'Active',
            'created_at' => '2023-05-03 11:34:54',
            'updated_at' => '2023-05-03 12:27:37',
        ];
        $user = User::create($data);

        // KYC
        KycVerification::create([
            'user_id' => $user->id,
            'id_type' => 'passport',
            'verifier' => 'MetaMap',
            'status' => 'Verified',
            'metadata' => '[{"identityStatus":"verified","timestamp":"2023-05-03T10:45:36.111558Z"}]',
            'created_at' => '2023-05-03 11:41:20',
            'updated_at' => '2023-05-03 11:41:20',
        ]);

        KycVerification::create([
            'user_id' => $user->id,
            'id_type' => 'NIN',
            'verifier' => 'Credequity',
            'status' => 'Verified',
            'metadata' => '{"first_name":"PATRICIA","middle_name":"KELECHI","last_name":"DURU","date_of_birth":"17-02-1980"}',
            'created_at' => '2023-05-03 11:41:20',
            'updated_at' => '2023-05-03 11:41:20',
        ]);

        $payment = Payment::create([
            'currency_id' => '1',
            'reference' => 'PRF_6908',
            'discount' => '0.00',
            'amount' => '8859.40',
            'fee' => '0.00',
            'user_id' => $user->id,
            'gateway' => 'Wallet',
            'activity' => 'PROPERTY_PURCHASE',
            'status' => 'Completed',
            'created_at' => '2023-05-03 11:41:20',
            'updated_at' => '2023-05-03 11:41:20',
        ]);

        // PaymentFile::create([
        //     'payment_id' => $payment->id,
        //     'user_id' => $user->id,
        //     'file_id' => '204',
        //     'status' => 'Pending',
        //     'created_at' => '2023-05-03 11:41:20',
        //     'updated_at' => '2023-05-03 11:41:20',
        // ]);

        Portfolio::create([
            'user_id' => $user->id,
            'monthly_income' => 0,
            'total_income' => 0,
            'value_appreciation' => 0,
            'investment_value' => 0,
            'current_value' => 0,
            'created_at' => '2023-05-03 11:41:20',
            'updated_at' => '2023-05-03 11:41:20',
        ]);


        $data =   [
            'first_name' => 'Chinedu',
            'last_name' => 'Igwebike',
            'email' => 'mooseman494@gmail.com',
            'password' => Hash::make('password'),
            'role' => "User",
            'phone_no' => '08172082266',
            'date_of_birth' => '17-02-1980',
            'ref_code' => 'C1uaO8Ba',
            'status' => 'Active',
            'created_at' => '2023-09-20 06:37:31',
            'updated_at' => '2023-09-20 06:37:31',
        ];
        
        $user = User::create($data);


        Portfolio::create([
            'user_id' => $user->id,
            'monthly_income' => 0,
            'total_income' => 0,
            'value_appreciation' => 0,
            'investment_value' => 0,
            'current_value' => 0,
            'created_at' => '2023-05-03 11:41:20',
            'updated_at' => '2023-05-03 11:41:20',
        ]);

        Wallet::create([
            'user_id' => $user->id,
            'currency_id' => '1',
            'balance' => 0,
            'locked_balance' => 0,
            'total_credit' => 0,
            'total_debit' => 0,
            'created_at' => '2023-05-03 11:41:20',
            'updated_at' => '2023-05-03 11:41:20',
        ]);
    }
}
