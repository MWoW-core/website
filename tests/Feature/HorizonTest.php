<?php

namespace Tests\Feature;

use App\User;
use App\Enums\UserRole;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HorizonTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminsCanViewHorizon()
    {
        $this
            ->actingAs(
                factory(User::class)->state(UserRole::Admin)->create()
            )
            ->get('/horizon')
            ->assertSuccessful();
    }

    public function testPlayerCannotViewHorizon()
    {
        $this
            ->actingAs(
                factory(User::class)->state(UserRole::Player)->create()
            )
            ->get('/horizon')
            ->assertStatus(403);
    }
}
