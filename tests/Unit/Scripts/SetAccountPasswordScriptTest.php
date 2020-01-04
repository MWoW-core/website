<?php

namespace Tests\Unit\Scripts;

use App\Scripts\SetAccountPasswordScript;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use const PHP_EOL;

class SetAccountPasswordScriptTest extends TestCase
{
    public function testScriptContent()
    {
        $script = new SetAccountPasswordScript('hello', 'world');

        $rendered = $script->contents();

        self::assertEquals(
            'ACCOUNT SET PASSWORD hello world world',
            $rendered
        );
    }
}
