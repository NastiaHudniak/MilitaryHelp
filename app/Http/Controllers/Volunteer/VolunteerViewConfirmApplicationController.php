<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VolunteerViewConfirmApplicationController extends Controller
{
    public function index()
    {
        $volunteer_id = Auth::id();
        $users = User::all();
        $categories = Category::all();
        $applications = Application::where('volunteer_id', $volunteer_id)->get();

        return view('user.volunteer.view_confirm_app', compact('applications', 'users', 'categories'));
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
        return redirect()->route('user.volunteer.view_confirm_app')->with('success', 'Коментар оновлено.');
    }



    public function deleteComment($applicationId)
    {
        $application = Application::find($applicationId);
        $application->comment = 'немає';
        $application->save();

        return redirect()->route('user.volunteer.view_confirm_app')->with('success', 'Коментар видалено.');
    }

    public function rejectApplication($applicationId)
    {
        $application = Application::find($applicationId);
        $application->status = 'створено'; // Змінюємо статус на "створено"
        $application->volunteer_id = null; // Встановлюємо volunteer_id в null
        $application->comment = 'немає';
        $application->save();

        return redirect()->route('user.volunteer.view_confirm_app')->with('success', 'Заявка відхилена.');
    }






    public function search(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category');
        $user_id = Auth::user()->id;

        $applications = Application::with(['category', 'volunteer', 'millitary'])
            ->when($query !== null && $query !== '', function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            })
            ->when($category, function($q) use ($category) {
                $q->whereHas('category', function($q) use ($category) {
                    $q->where('name', $category);
                });
            })
            ->when($query === null || $query === '', function($q) use ($user_id) {
                $q->where('millitary_id', $user_id);
            })
            ->get();

        return response()->json(['applications' => $applications]);
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
}
