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

        return view('user.volunteer.confirm.view_confirm_app', compact('applications', 'users', 'categories'));
    }

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
    public function filter(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category_id');
        $status = $request->input('status');

        $applications = Application::with(['category', 'volunteer', 'millitary'])
            ->when($query, function($queryBuilder) use ($query) {
                $queryBuilder->where('title', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            })
            ->when($category, function($queryBuilder) use ($category) {
                $queryBuilder->where('category_id', $category);
            })
            ->when($status, function($queryBuilder) use ($status) {
                $queryBuilder->where('status', $status);
            })
            ->get();

        return response()->json(['applications' => $applications]);
    }

    public function generatePDF($id)
    {
        $application = Application::findOrFail($id);
        $pdf = Pdf::loadView('user.volunteer.pdf', compact('application'));
        
        return $pdf->download('application-'.$application->id.'.pdf');
    }
}
