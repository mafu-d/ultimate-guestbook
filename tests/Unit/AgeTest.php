<?php

namespace Tests\Feature;

use App\ValueObjects\Age;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AgeTest extends TestCase
{
    public function testValidRange()
    {
        $age = new Age(18);
        $this->assertEquals(18, $age->toNative());

        $age = new Age(30);
        $this->assertEquals(30, $age->toNative());

        $age = new Age(120);
        $this->assertEquals(120, $age->toNative());
    }

    public function testAgeFromString()
    {
        $age = new Age('20');
        $this->assertEquals(20, $age->toNative());
    }

    public function testAgeFailsWhenTooLow()
    {
        $this->expectException(ValidationException::class);
        $age = new Age(17);
    }

    public function testAgeFailsWhenTooHigh()
    {
        $this->expectException(ValidationException::class);
        $age = new Age(121);
    }

    public function testAgeFailsWhenNotNumeric()
    {
        $this->expectException(ValidationException::class);
        $age = new Age('old');
    }
}
