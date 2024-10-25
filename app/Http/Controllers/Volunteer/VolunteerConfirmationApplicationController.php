<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VolunteerConfirmationApplicationController extends Controller
{
    public function index($id)
    {
        // Отримуємо інформацію про заявку за її ID
        $application = Application::findOrFail($id);

        // Отримуємо інформацію про військового, який опублікував заявку
        $millitary = User::findOrFail($application->millitary_id);

        // Повертаємо вигляд із передачею інформації про військового та заявку
        return view('user.volunteer.confirm_application', [
            'millitary' => $millitary,
            'application' => $application
        ]);
    }

    public function confirm(Request $request, $id)
    {
        // Отримуємо заявку за її ID
        $application = Application::findOrFail($id);

        // Оновлюємо поле comment (якщо користувач залишив коментар)
        if ($request->has('comment') && !empty($request->comment)) {
            $application->comment = $request->comment;
        }

        // Змінюємо статус заявки на "прийнято" і додаємо ID авторизованого волонтера
        $application->status = 'прийнято';
        $application->volunteer_id = Auth::id();

        // Зберігаємо зміни
        $application->save();

        // Перенаправляємо на попередню сторінку або сторінку з підтвердженням
        return redirect()->route('user.volunteer.index')->with('success', 'Заявку підтверджено.');
    }
}
