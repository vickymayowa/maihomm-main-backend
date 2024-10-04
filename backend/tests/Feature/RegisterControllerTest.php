<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
{
    parent::setUp();
    
    DB::statement('PRAGMA foreign_keys = OFF;');
    config(['database.connections.sqlite.database' => ':memory:']);
    $this->artisan('migrate');
}

    public function tearDown(): void
{
    DB::statement('PRAGMA foreign_keys = ON;');

    parent::tearDown();
}


    public function test_register()
    {
        // Mock ReferralService
        $referralServiceMock = Mockery::mock('alias:App\Services\Auth\ReferralService');
        $referralServiceMock->shouldReceive('newReferral')->andReturn(true);

        // Mock User creation
        $userMock = Mockery::mock('alias:App\Models\User');
        $userMock->shouldReceive('create')
            ->once()
            ->andReturn((object)[
                'id' => 1,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'johndoe@example.com',
                'phone_no' => '1234567890',
                'nationality' => 'US',
                'password' => Hash::make('Password@123'),
            ]);

        // Simulate the registration request
        $response = $this->post('/register', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'phone_no' => '1234567890',
            'country_code' => '+1',
            'nationality' => 'US',
            'password' => 'Password@123',
            'password_confirmation' => 'Password@123',
        ]);

        // Debug the response
        dd($response->getContent());

        // Check if redirection is correct
        $response->assertStatus(302); // Adjust based on your logic
        $response->assertRedirect(route('dashboard.user.show-kyc-page')); // Adjust based on your logic
    }
}
