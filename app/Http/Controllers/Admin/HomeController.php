<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Application; // Додати модель Application
use App\Models\User; // Додати модель User
use Illuminate\Support\Facades\DB; // Додати для виконання SQL запитів

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('role');
        $totalApplications = Application::count();
        $totalUsers = User::count();
        $totalVolunteers = User::where('role_id', 3)->count();
        $topMilitary = DB::table('applications')
            ->select('millitary_id', DB::raw('count(*) as total'))
            ->groupBy('millitary_id')
            ->orderBy('total', 'desc')
            ->first();
        $topMilitaryName = $topMilitary ? User::find($topMilitary->millitary_id)->name : 'Немає';

        $applicationsCreated = Application::where('status', 'створено')->count();
        $applicationsAccepted = Application::where('status', 'прийнято')->count();
        $applicationsRejected = Application::where('status', 'відхилено')->count();

        $userApplications = Application::selectRaw('millitary_id, COUNT(*) as total')
                        ->groupBy('millitary_id')
                        ->with('millitary')
                        ->get()
                        ->map(function($application) {
                            return [
                                'user' => $application->millitary->login ?? 'Unknown',
                                'total' => $application->total
                            ];
                        });

        return view('admin.home.index', [
            'user' => $user,
            'totalApplications' => $totalApplications,
            'totalUsers' => $totalUsers,
            'totalVolunteers' => $totalVolunteers,
            'topMilitaryName' => $topMilitaryName,
            'applicationsCreated' => $applicationsCreated,
            'applicationsAccepted' => $applicationsAccepted,
            'applicationsRejected' => $applicationsRejected,
            'userApplications' => $userApplications,
        ]);
    }
}
