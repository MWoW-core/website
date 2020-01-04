<?php

namespace App\Http\Controllers;

use App\Server;
use Illuminate\Http\Request;
use function response;

class DownloadServerRealmlist extends Controller
{
    public function __invoke(Server $server)
    {
        $this->authorize('view', $server);

        return response()->streamDownload(static function () use ($server) {
            echo "SET REALMLIST {$server->realmlist}";
        }, 'realmlist.wtf');
    }
}
