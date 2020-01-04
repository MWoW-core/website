<?php

namespace App\Http\Controllers;

use App\Server;
use Illuminate\Http\Request;
use function view;

class ListServers extends Controller
{
    public function __invoke(Request $request)
    {
        $this->authorize('viewAny', new Server);

        return view('servers.index');
    }
}
