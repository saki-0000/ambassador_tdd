<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function index()
    {
        $user = User::find(1000);
        return $user->links()->get();
    }
}
