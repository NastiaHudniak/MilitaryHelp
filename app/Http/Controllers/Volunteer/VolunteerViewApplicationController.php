<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Barryvdh\DomPDF\Facade\Pdf;


class VolunteerViewApplicationController extends Controller
{
    public function index()
    {
        $users = User::all();
        $categories = Category::all();
        $applications = Application::with('images')
        ->whereNull('volunteer_id')
            ->orderByDesc('is_urgent')
        ->get();
        $userLikedApplicationIds = auth()->check()
            ? auth()->user()->likedApplications()->pluck('application_id')->toArray()
            : [];


        return view('user.volunteer.view_app', compact('applications', 'users', 'categories', 'userLikedApplicationIds'));


    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'volunteer_id' => 'required|exists:users,id',
            'millitary_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'status' => 'required|string|max:255',
            'comment' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Application::create([
            'category_id' => $request->input('category_id'),
            'volunteer_id' => $request->input('volunteer_id'),
            'millitary_id' => $request->input('millitary_id'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->route('user.volunteer.index')->with('success', 'Заявка створена успішно!');
    }




    public function getFilteredApplications(Request $request)
    {
        $user_id = Auth::id();

        $query = Application::with(['images', 'category', 'millitary', 'likedByUsers'])
            ->whereNull('volunteer_id'); // тільки відкриті заявки

        // Фільтри
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === "created") $status = "створено";
            elseif ($status === "accept") $status = "прийнято";
            elseif ($status === "cancel") $status = "відхилено";
            $query->where('status', $status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('urgent') && $request->urgent === 'true') {
            $query->where('is_urgent', true);
        }

        // Сортування
        $sort = $request->input('sort', 'urgent_oldest');
        if ($sort === 'urgent_oldest') {
            $query->orderByDesc('is_urgent')->orderBy('created_at', 'asc');
        } elseif ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sort === 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($sort === 'title') {
            $query->orderBy('title', 'asc');
        }

        $applications = $query->get();

        // Позначаємо, які заявки лайкнуті поточним волонтером
        $applications->map(function ($application) use ($user_id) {
            $application->is_liked = $application->likedByUsers->contains('id', $user_id);
            return $application;
        });

        // HTML рендеринг
        $html = '';
        foreach ($applications as $application) {
            $html .= view('components.application-card-vol', compact('application'))->render();
        }

        return response()->json([
            'sort' => $sort,
            'html' => $html,
        ]);
    }




//    public function generatePDF($id)
//    {
//        $application = Application::with(['category', 'volunteer', 'images'])->findOrFail($id);
//        $pdf = Pdf::loadView('user.volunteer.pdf', compact('application'));
//
//        return $pdf->download('application-' . $application->id . '.pdf');
//    }

    public function generatePDF($id)
    {
        $user = Auth::user(); // військовий
        $date = \Carbon\Carbon::now()->format('d.m.Y');
        $fullName = $user->surname . ' ' . $user->name;
        $application = Application::with(['category', 'volunteer', 'images'])->findOrFail($id);
        $pdf = Pdf::loadView('user.volunteer.pdf', compact('application', 'date', 'fullName'));
        //return view('user.military.pdf', compact('application'));
        return $pdf->download('application-'.$application->id.'.pdf');

    }

    public function exportAllApplicationsToPDF()
    {
        $user = Auth::user();

        $applications = \App\Models\Application::with(['category', 'volunteer', 'images'])
            ->whereNull('volunteer_id')
            ->get();

        $applicationCount = $applications->count();
        $date = \Carbon\Carbon::now()->format('d.m.Y');
        $fullName = $user->surname . ' ' . $user->name;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('user.military.all_applications_pdf', compact('applications', 'applicationCount', 'date', 'fullName'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('all_applications_'.$user->id.'.pdf');
    }
}
