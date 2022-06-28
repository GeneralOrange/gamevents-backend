<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Show the profile for a given user.
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        return view('summoner.profile', [
            'summoner' => User::findOrFail($id)
        ]);
    }
}
