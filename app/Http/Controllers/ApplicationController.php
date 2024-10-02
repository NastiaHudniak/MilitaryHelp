<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\User;
use App\Models\ApplicationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::with(['category', 'volunteer_id', 'military_id '])->get();
        return view('admin.applications.index', compact('applications'));
    }

    public function create()
    {
        $categories = ApplicationCategory::all();
        $users = User::all(); // Отримуємо всіх користувачів для вибору волонтера та військового
        return view('admin.applications.create', compact('categories', 'users'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:application_categories,id',
            'volunteer_id' => 'required|exists:users,id',
            'military_id' => 'required|exists:users,id',
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
            'military_id' => $request->input('military_id'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->route('admin.applications.index')->with('success', 'Заявка створена успішно!');
    }

    public function edit($id)
    {
        $application = Application::findOrFail($id);
        $categories = ApplicationCategory::all();
        $users = User::all(); // Отримуємо всіх користувачів для вибору волонтера та військового
        return view('admin.applications.edit', compact('application', 'categories', 'users'));
    }

    public function update(Request $request, $id)
    {
        $application = Application::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required|exists:application_categories,id',
            'volunteer_id' => 'required|exists:users,id',
            'military_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'status' => 'required|string|max:255',
            'comment' => 'nullable|string|max:1000',
        ]);

        $application->update($validated);

        return redirect()->route('admin.applications.index')->with('success', 'Заявка оновлена успішно!');
    }

    public function destroy(Application $application)
    {
        $application->delete();
        return redirect()->route('admin.applications.index')->with('error', 'Заявка видалена успішно!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $applications = Application::with(['category', 'volunteer', 'military'])
            ->where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->get();

        return response()->json(['applications' => $applications]);
    }

    public function filter(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category_id');
        $status = $request->input('status');

        $applications = Application::with(['category', 'volunteer', 'military'])
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
