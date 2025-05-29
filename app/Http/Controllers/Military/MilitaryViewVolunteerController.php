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

        foreach ($volunteers as $volunteer) {
            $ratings = VolunteerRating::where('user_id', $volunteer->id)->pluck('rating');
            $volunteer->average_rating = $ratings->isNotEmpty() ? $ratings->avg() : 0;
        }

        $roles = Role::all();

        return view('user.military.vol.view_volunteer', compact('volunteers', 'roles'));
    }



    public function search(Request $request)
    {
        $query = $request->input('query');
        $filter = $request->input('filter'); // 'favorites' або 'known' або null
        $sort = $request->input('sort'); // 'alphabet' або 'rating' або null

        $user = Auth::user();

        $volunteersQuery = User::where('role_id', 3)->with('images');

        // Пошук по імені або прізвищу
        if ($query) {
            $volunteersQuery->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('surname', 'like', '%' . $query . '%');
            });
        }

        if ($filter === 'favorites') {
            $favoriteIds = $user->favorites->pluck('id')->toArray();
            $volunteersQuery->whereIn('id', $favoriteIds);
        }

        if ($filter === 'known') {
            $applicationVolunteerIds = Application::where('millitary_id', $user->id)
                ->whereNotNull('volunteer_id')
                ->pluck('volunteer_id')
                ->unique()
                ->toArray();

            $volunteersQuery->whereIn('id', $applicationVolunteerIds);
        }

        $volunteers = $volunteersQuery->get();

        // Додаємо середній рейтинг і поле is_favorite
        $favoriteIds = $user->favorites->pluck('id')->toArray();

        foreach ($volunteers as $volunteer) {
            $ratings = VolunteerRating::where('user_id', $volunteer->id)->pluck('rating');
            $volunteer->average_rating = $ratings->isNotEmpty() ? $ratings->avg() : 0;
            $volunteer->is_favorite = in_array($volunteer->id, $favoriteIds);
        }

        if ($sort === 'alphabet') {
            $volunteers = $volunteers->sortBy(fn($v) => $v->name)->values();
        } elseif ($sort === 'rating') {
            $volunteers = $volunteers->sortByDesc(fn($v) => $v->average_rating)->values();
        }

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
