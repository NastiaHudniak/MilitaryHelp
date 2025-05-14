<?php

namespace App\Http\Controllers\Military;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\VolunteerRating;
use Illuminate\Http\Request;


class VolunteerRatingController extends Controller
{
    public function showRatingForm($volunteerId)
    {
        // Перевірка, чи є підтверджена заявка для цього волонтера
        $application = Application::where('volunteer_id', $volunteerId)
            ->where('status', 'прийнято')
            ->where('user_id', auth()->user()->id)
            ->first();

        if (!$application) {
            return redirect()->route('home')->with('error', 'Ви не можете поставити рейтинг цьому волонтеру.');
        }

        return view('user.volunteer.rating', compact('volunteerId'));
    }

    // Збереження рейтингу
    public function storeRating(Request $request, $volunteerId)
    {
        $validated = $request->validate([
            'rating' => 'nullable|integer|in:1,2,3,4,5', // дозволяємо тільки 1-5 або null
        ]);

        // Зберігаємо рейтинг
        VolunteerRating::updateOrCreate(
            ['user_id' => auth()->user()->id, 'volunteer_id' => $volunteerId],
            ['rating' => $validated['rating'] ?? null]
        );

        return redirect()->route('home')->with('success', 'Рейтинг збережено!');
    }
}
