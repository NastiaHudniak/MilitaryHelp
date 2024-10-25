<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\User;

class VolunteerViewInfoMilitaryController extends Controller
{
    public function index($id)
    {
        // Отримуємо інформацію про конкретного військового за його ID з таблиці users
        $millitary = User::findOrFail($id);

        // Отримуємо заявки, де volunteer_id = null для цього військового
        $applications = Application::where('millitary_id', $id)
            ->whereNull('volunteer_id')
            ->get();

        // Повертаємо вигляд (view) з передачею даних військового та заявок
        return view('user.volunteer.view_info_military', [
            'millitary' => $millitary,
            'applications' => $applications
        ]);
    }
}
