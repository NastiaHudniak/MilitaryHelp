<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;

use App\Models\Application;

class VolunteerHomeController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('role');

        $applications = Application::with('images')
            ->whereNull('volunteer_id')
            -> where('is_urgent',1)
            ->get();
        $totalApplications = Application::where('volunteer_id', $user->id)->count();


        return view('user.volunteer.index', compact('user', 'applications','totalApplications'));

    }

    // Метод для відображення сторінки заявок
    public function applications()
    {
        return view('admin.applications'); // Повертає шаблон admin.applications
    }
}
