<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function view;

class ShowWelcome extends Controller
{
    public function __invoke(Request $request)
    {
        return view('welcome');
    }
}
