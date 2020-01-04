<?php

namespace Tests\Unit;

use App\Realm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RealmTest extends TestCase
{
    public function test_it_encrypts_the_admin_credentials()
    {
        $realm = new Realm([
            'admin_name' => 'Admin',
            'admin_password' => 'password'
        ]);

        self::assertNotEquals('Admin', $realm->getAttributes()['admin_name']);
        self::assertEquals('Admin', $realm->admin_name);

        self::assertNotEquals('password', $realm->getAttributes()['admin_password']);
        self::assertEquals('password', $realm->admin_password);
    }
}
