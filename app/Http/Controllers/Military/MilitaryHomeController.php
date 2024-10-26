<?php

namespace App\Http\Controllers\Military;

use App\Http\Controllers\Controller;
use App\Models\Application;

class MilitaryHomeController extends Controller
{
    // Метод для відображення сторінки користувачів
    public function index()
    {

        $user = auth()->user()->load('role');

        $totalApplications = Application::where('millitary_id', $user->id)->count();

        // Отримати кількість прийнятих заявок (де volunteer_id не є порожнім)
        $acceptedApplications = Application::where('millitary_id', $user->id)
            ->whereNotNull('volunteer_id')
            ->count();

        return view('user.military.index', compact('user', 'totalApplications', 'acceptedApplications')); // Повертає шаблон admin.users
    }

    // Метод для відображення сторінки заявок
    public function applications()
    {
        return view('admin.applications'); // Повертає шаблон admin.applications
    }
}
