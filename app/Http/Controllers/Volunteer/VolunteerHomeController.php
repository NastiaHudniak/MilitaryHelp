<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;

use App\Models\Application;

class VolunteerHomeController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('role');
// Отримати заявки з описом, що містить слово "ТЕРМІНОВО"
$urgentOrCreatedApplications = Application::where('status', 'створено')
->where('description', 'like', '%ТЕРМІНОВО%')
->get();

        $totalApplications = Application::where('volunteer_id', $user->id)->count();

       
        return view('user.volunteer.index', compact('user','urgentOrCreatedApplications', 'totalApplications'));

    }

    // Метод для відображення сторінки заявок
    public function applications()
    {
        return view('admin.applications'); // Повертає шаблон admin.applications
    }
}
