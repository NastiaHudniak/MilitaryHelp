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
        $totalApplications = cache()->remember('total_applications', 60, function () {
            return Application::count();
        });

        $totalUsers = User::count();
        $totalVolunteers = User::where('role_id', 3)->count();
        $topMilitary = cache()->remember('top_military', 300, function () {
            return DB::table('applications')
                ->join('users', 'applications.millitary_id', '=', 'users.id')
                ->select('applications.millitary_id', 'users.name', DB::raw('count(*) as total'))
                ->groupBy('applications.millitary_id', 'users.name')
                ->orderBy('total', 'desc')
                ->first();
        });
        $topMilitaryName = $topMilitary->name ?? 'Немає';


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
