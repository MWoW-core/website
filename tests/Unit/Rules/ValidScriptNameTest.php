<?php

namespace Tests\Unit\Rules;

use App\Rules\ValidScriptName;
use App\Scripts\CreateAccountScript;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ValidScriptNameTest extends TestCase
{
    protected ValidScriptName $rule;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rule = new ValidScriptName;
    }

    public function testItFailsANonExistingScriptName()
    {
        self::assertFalse(
            $this->rule->passes('testing', 'invalid-script-name')
        );
    }

    public function testItPassesAnExistingScriptName()
    {
        self::assertTrue(
            $this->rule->passes('testing', CreateAccountScript::name())
        );
    }
}
