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


class VolunteerViewConfirmApplicationController extends Controller
{
    public function index()
    {
        $volunteer_id = Auth::id();
        $users = User::all();
        $categories = Category::all();
        $applications = Application::with('images')
            ->where('volunteer_id', $volunteer_id)
            ->get();

        $userLikedApplicationIds = auth()->check()
            ? auth()->user()->likedApplications()->pluck('application_id')->toArray()
            : [];

        return view('user.volunteer.confirm.view_confirm_app', compact(
            'applications',
            'users',
            'categories',
            'userLikedApplicationIds'
        )); }

    public function edit($id)
    {
        $application = Application::findOrFail($id);
        $categories = Category::all();

        return view('user.volunteer.confirm.edit_confirm_app', compact('application', 'categories'));
    }

    // VolunteerViewConfirmApplicationController.php
    public function update(Request $request, $applicationId)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $application = Application::find($applicationId);
        $application->comment = $request->comment;
        $application->save();

        // Перенаправлення на сторінку перегляду підтверджених заявок
        return redirect()->route('user.volunteer.confirm.view_confirm_app')->with('success', 'Коментар оновлено.');
    }



    public function deleteComment($applicationId)
    {
        $application = Application::find($applicationId);
        $application->comment = 'немає';
        $application->save();

        return redirect()->route('user.volunteer.confirm.view_confirm_app')->with('success', 'Коментар видалено.');
    }

    public function rejectApplication($applicationId)
    {
        $application = Application::find($applicationId);
        $application->status = 'створено';
        $application->volunteer_id = null;
        $application->comment = 'немає';
        $application->save();

        return redirect()->route('user.volunteer.confirm.view_confirm_app')->with('success', 'Заявка відхилена.');
    }






    public function search(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category');
        $sort = $request->input('sort');
        $volunteer_id = Auth::id();

        $applications = Application::with(['category', 'volunteer', 'millitary', 'images'])
            // ->when($user_id, function($q) use ($user_id) {
            //     $q->where('millitary_id', $user_id);
            // })
            ->where('volunteer_id', $volunteer_id)
            // ->where('category_id', $category)
            ->when(!is_null($category), function($q) use ($category) {
                $q->where('category_id', $category);
            })
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%");
            });

        if ($sort === 'latest') {
            $applications->orderBy('created_at', 'desc');
        } elseif ($sort === 'oldest') {
            $applications->orderBy('created_at', 'asc');
        }

        return response()->json(['applications' => $applications->get()]);
    }


//
//
//
//
    public function getFilteredApplications(Request $request)
    {
        $user_id = Auth::id();

        $query = Application::with(['images', 'category', 'millitary', 'likedByUsers'])
            ->where('volunteer_id', $user_id);


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


    public function generatePDF($id)
    {
        $application = Application::findOrFail($id);
        $pdf = Pdf::loadView('user.volunteer.pdf', compact('application'));

        return $pdf->download('application-'.$application->id.'.pdf');
    }

    public function exportAllApplicationsToPDF()
    {
        $user = Auth::user();
        $user_id = $user->id;

        $applications = \App\Models\Application::with(['category', 'volunteer', 'images'])
            ->where('volunteer_id', $user_id)
            ->get();

        $applicationCount = $applications->count();
        $date = \Carbon\Carbon::now()->format('d.m.Y');
        $fullName = $user->surname . ' ' . $user->name;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'user.military.all_applications_pdf', // перевір цей шлях
            compact('applications', 'applicationCount', 'date', 'fullName')
        )->setPaper('a4', 'portrait');

        return $pdf->download('all_applications_'.$user->id.'.pdf');
    }

}
