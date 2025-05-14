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

        $acceptedApplications = Application::where('millitary_id', $user->id)
            ->whereNotNull('volunteer_id')
            ->count();

        $confirmedApplications = Application::with('volunteer')
            ->where('millitary_id', auth()->id())
            ->where('status', 'прийнято')
            ->get();

        return view('user.military.index', compact(
            'user',
            'totalApplications',
            'acceptedApplications',
            'confirmedApplications'
        ));

    }

    // Метод для відображення сторінки заявок
    public function applications()
    {
        return view('admin.applications'); // Повертає шаблон admin.applications
    }
}
