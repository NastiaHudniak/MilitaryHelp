<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\User;

class VolunteerViewInfoMilitaryController extends Controller
{
    public function index($id)
    {
        $military = User::findOrFail($id); // ✔️ правильна назва змінної

        $applications = Application::with('images')
            ->where('millitary_id', $id)
            ->whereNull('volunteer_id')
            ->get();

        $userImage = $military->images()->first(); // ✔️

        return view('user.volunteer.view_info_military', [
            'millitary' => $military,
            'applications' => $applications,
            'userImage' => $userImage
        ]);
    }
}
