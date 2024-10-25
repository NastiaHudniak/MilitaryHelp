<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\User;

class LandingController extends Controller
{
    public function index()
    {
        // Отримуємо всіх волонтерів (role_id = 3) разом з їхніми зображеннями
        $volunteers = User::where('role_id', 2)->with('images')->get();

        return view('user.landing.index', compact('volunteers'));
    }


}

