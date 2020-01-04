<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Fluent;
use function action;
use function view;

class ShowHome extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user()->loadMissing('accounts', 'accounts.server');

        return view('home')->with('user', new Fluent([
            'account_name' => $user->account_name,
            'role' => $user->role,
            'email' => $user->email,

            'accounts' => $user->accounts
        ]));
    }
}
