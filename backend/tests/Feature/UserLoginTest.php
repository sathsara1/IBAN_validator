<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;

class UserLoginTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_can_login()
    {
        $user = User::factory()->create(['password' => bcrypt('abcd1234')]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
    }
}
