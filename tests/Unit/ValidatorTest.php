<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function test_example(): void
    {
        $this->assertTrue(true);
    }
    public function it_validates_email_correctly()
    {
        $data = ['email' => 'invalid-email'];
        $rules = ['email' => 'required|email'];
        $validator = Validator::make($data, $rules);
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('email', $validator->errors()->messages());}}

