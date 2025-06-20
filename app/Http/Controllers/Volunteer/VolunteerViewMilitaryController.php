<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Role;
use App\Models\User;
use App\Models\VolunteerRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VolunteerViewMilitaryController extends Controller
{
    public function index()
    {
        // Отримати тільки волонтерів, де role_id = 3
        $militaries = User::where('role_id', 2)->with('role')->get();

        // Якщо хочете отримати також усі ролі для фільтрації чи іншої мети
        $roles = Role::all();

        // Повернути вид з волонтерами та ролями
        return view('user.volunteer.mil.view_military', compact('militaries', 'roles'));
    }




    public function search(Request $request)
    {
        $query = $request->input('query');
        $filter = $request->input('filter');
        $sort = $request->input('sort');

        $user = Auth::user();

        $militariesQuery = User::where('role_id', 2)->with('images');

        // Пошук по імені або прізвищу
        if ($query) {
            $militariesQuery->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('surname', 'like', '%' . $query . '%');
            });
        }

        if ($filter === 'favorites') {
            $favoriteIds = $user->favorites->pluck('id')->toArray();
            $militariesQuery->whereIn('id', $favoriteIds);
        }

        $militaries = $militariesQuery->get();

        // Додаємо середній рейтинг і поле is_favorite
        $favoriteIds = $user->favorites->pluck('id')->toArray();

        foreach ($militaries as $military) {
            $military->is_favorite = in_array($military->id, $favoriteIds);
        }

        if ($sort === 'alphabet') {
            $militaries = $militaries->sortBy(fn($v) => $v->name)->values();
        }elseif ($sort === 'favorites_first') {
            $militaries = $militaries
                ->sortByDesc(fn($v) => $v->is_favorite)
                ->values();
        }

        return response()->json(['$militaries' => $militaries]);
    }


}
