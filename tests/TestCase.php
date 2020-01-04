<?php

namespace Tests;

use App\Enums\UserRole;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function as(UserRole $role, $guard = null)
    {
        return $this->actingAs(
            factory(User::class)->state((string)$role)->create(),
            $guard
        );
    }
}
