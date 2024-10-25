<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class VolunteerViewMilitaryController extends Controller
{
    public function index()
    {
        // Отримати тільки волонтерів, де role_id = 3
        $militaries = User::where('role_id', 2)->with('role')->get();

        // Якщо хочете отримати також усі ролі для фільтрації чи іншої мети
        $roles = Role::all();

        // Повернути вид з волонтерами та ролями
        return view('user.volunteer.view_military', compact('militaries', 'roles'));
    }


}
