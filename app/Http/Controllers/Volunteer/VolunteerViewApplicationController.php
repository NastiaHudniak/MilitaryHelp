<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VolunteerViewApplicationController extends Controller
{
    public function index()
    {
        $users = User::all();
        $categories = Category::all();
        $applications = Application::whereNull('volunteer_id')->get();

        return view('user.volunteer.view_app', compact('applications', 'users', 'categories'));
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
