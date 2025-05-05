<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\User;

use App\Models\Application; // Додати модель Application

class LandingController extends Controller
{
    public function index()
    {
        // Отримуємо всіх волонтерів (role_id = 3) разом з їхніми зображеннями
        $volunteers = User::where('role_id', 3)->with('images')->get();

        // Підраховуємо загальну кількість заявок
        $totalApplications = Application::count();

        // Підраховуємо кількість заявок, де є волонтер (тобто, де volunteer_id не null)
        $completedApplications = Application::whereNotNull('volunteer_id')->count();

        // Обчислюємо відсоток виконаних заявок
        $completedPercentage = ($totalApplications > 0) ? ($completedApplications / $totalApplications) * 100 : 0;

        // Підраховуємо кількість користувачів та волонтерів
        $totalUsers = User::count();
        $totalVolunteers = User::where('role_id', 3)->count();

        // Повертаємо дані в вигляді view
        return view('user.landing.index', [
            'totalApplications' => $totalApplications,
            'totalUsers' => $totalUsers,
            'totalVolunteers' => $totalVolunteers,
            'volunteers' => $volunteers,
            'completedPercentage' => $completedPercentage, // Додаємо відсоток виконаних заявок
        ]);
    }



}

