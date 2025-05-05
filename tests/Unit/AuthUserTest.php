<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class AuthUserTest extends TestCase
{
    public function test_example(): void
    {
        $this->assertTrue(true);
    }
    public function it_creates_a_user_in_the_database()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',]);}}
