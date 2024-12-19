<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use DatabaseTransactions;

    public function test_user_can_register()
    {

        $user = User::factory()->create(['password' => bcrypt('abcd1234')])->toArray();

        $response = $this->post('/register', $user);

        $this->assertDatabaseHas('users', ['email' => $user['email']]);
    }
}
