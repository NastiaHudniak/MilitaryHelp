<?php

namespace App\Http\Controllers\Military;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Role;
use App\Models\User;
use App\Models\VolunteerRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MilitaryViewVolunteerController extends Controller
{
    public function index()
    {
        $volunteers = User::where('role_id', 3)->with('images')->with('role')->get();

        // Додаємо середній рейтинг для кожного волонтера
        foreach ($volunteers as $volunteer) {
            // Отримуємо всі рейтинги для поточного волонтера
            $ratings = VolunteerRating::where('user_id', $volunteer->id)->pluck('rating');

            // Обчислюємо середнє значення рейтингу
            $volunteer->average_rating = $ratings->isNotEmpty() ? $ratings->avg() : 0;
        }

        $roles = Role::all();

        return view('user.military.vol.view_volunteer', compact('volunteers', 'roles'));
    }

    public function search(Request $request)
{
    $query = $request->input('query');

    $volunteers = User::where('role_id', 3)
                            ->where(function ($q) use ($query) {
                                $q->where('name', 'like', '%' . $query . '%')
                                ->orWhere('surname', 'like', '%' . $query . '%');
                            })
                            ->with('images')
                            ->get();

    return response()->json(['volunteers' => $volunteers]);
}




//    public function search(Request $request)
//    {
//        $query = $request->input('query');
//
//        // Пошук серед користувачів з role_id = 3 (волонтери)
//        $volunteers = User::where('role_id', 3)
//            ->when($query !== null && $query !== '', function ($q) use ($query) {
//                $q->where(function ($queryBuilder) use ($query) {
//                    $queryBuilder->where('name', 'like', "%{$query}%")
//                        ->orWhere('surname', 'like', "%{$query}%");
//                });
//            })
//            ->get();
//
//        return response()->json(['volunteers' => $volunteers]);
//    }

}
