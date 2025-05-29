<?php

namespace App\Http\Controllers\Military;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\VolunteerRating;
use Illuminate\Http\Request;

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


    public function rateVolunteer(Application $application)
    {
        // Перевірка, чи військовий може поставити рейтинг (якщо це підтверджена заявка)
        if ($application->status === 'прийнято' && !$application->volunteerRating) {
            return view('user.military.rate', compact('application'));
        }

        return redirect()->route('user.military.index')->with('message', 'Ви вже оцінили цього волонтера або не можете поставити рейтинг.');
    }

    public function storeRating(Request $request, Application $application)
    {
        $request->validate([
            'rating' => 'required|in:1,2,3,4,5', // Оцінка від 1 до 5
        ]);

        // Створення рейтингу
        VolunteerRating::create([
            'user_id' => $application->volunteer_id,
            'rating' => $request->rating,
        ]);

        // Оновлення статусу, що рейтинг вже поставлений
        $application->update(['rating_given' => true]);

        return redirect()->route('user.military.index')->with('message', 'Рейтинг успішно збережено!');
    }


    // Метод для відображення сторінки заявок
    public function applications()
    {
        return view('admin.applications'); // Повертає шаблон admin.applications
    }
}
