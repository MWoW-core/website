<?php

namespace Tests\Unit\Scripts;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Scripts\CreateAccountScript;
use const PHP_EOL;

class CreateAccountScriptTest extends TestCase
{
    public function testScriptContent()
    {
        $script = new CreateAccountScript('hello', 'world');

        $rendered = $script->contents();

        self::assertEquals(
            'ACCOUNT CREATE hello world world',
            $rendered
        );
    }
}
