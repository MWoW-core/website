<?php

namespace Tests\Feature;

use App\Server;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServerRealmlistControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    public function testCanDownloadARealmlistDotWtfFile()
    {
        $server = factory(Server::class)->create(['realmlist' => 'login.wowserver.com']);

        $response = $this->get(route('servers.realmlist.show', $server));
        $response->assertSuccessful();
        $response->assertHeader('content-type', 'text/html; charset=UTF-8');
        $response->assertHeader('content-disposition', 'attachment; filename=realmlist.wtf');

        self::assertEquals('SET REALMLIST login.wowserver.com', $response->streamedContent());
    }
}
