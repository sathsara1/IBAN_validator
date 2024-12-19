<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     */
    public function  test_user_has_a_role()
    {
        $user = User::factory()->create(['role' => 'admin'])->toArray();
        $this->assertEquals('admin', $user['role']);
    }
}
