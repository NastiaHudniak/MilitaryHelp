<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;

class VolunteerHomeController extends Controller
{
    public function index()
    {
        return view('user.volunteer.index'); // Повертає шаблон admin.users
    }

    // Метод для відображення сторінки заявок
    public function applications()
    {
        return view('admin.applications'); // Повертає шаблон admin.applications
    }
}
