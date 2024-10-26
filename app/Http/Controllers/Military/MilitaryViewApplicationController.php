<?php

namespace App\Http\Controllers\Military;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MilitaryViewApplicationController extends Controller
{
    public function index()
    {
        $users = User::all();
        $categories = Category::all();
        $user_id = Auth::user()->id;
        $applications = Application::where('millitary_id',  $user_id)->get();
        return view('user.military.view_app', compact('applications','users', 'categories'));
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

        return redirect()->route('user.military.index')->with('success', 'Заявка створена успішно!');
    }

    public function edit($id)
    {
        $applications = Application::findOrFail($id);
        $categories = Category::all();
        $users = User::all();
        return view('user.military.edit', compact('applications', 'categories', 'users'));
    }

    public function update(Request $request, $id)
    {
        $applications = Application::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        $applications->update($validated);

        return redirect()->route('user.military.view_app')->with('success', 'Заявка оновлена успішно!');
    }

    public function destroy(Application $applications)
    {
        $applications->delete();
        return redirect()->route('user.military.view_app')->with('error', 'Заявка видалена успішно!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $user_id = Auth::user()->id;

        $applications = Application::with(['category', 'volunteer', 'millitary'])
            ->where('military_id', $user_id) // Додайте фільтр за military_id
            ->when($query !== null && $query !== '', function($q) use ($query) {
                $q->where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('title', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
                });
            })
            ->get();

        return response()->json(['applications' => $applications]);
    }




    public function filter(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category');
        $sort = $request->input('sort');

        $applications = Application::with('category', 'volunteer', 'millitary');

        if ($category) {
            $applications->where('category_id', $category);
        }

        if ($query) {
            $applications->where('title', 'LIKE', "%{$query}%");
        }

        // Додайте логіку для сортування
        if ($sort === 'latest') {
            $applications->orderBy('created_at', 'desc');
        } elseif ($sort === 'oldest') {
            $applications->orderBy('created_at', 'asc');
        } elseif ($sort === 'status') {
            $applications->orderBy('status', 'asc');
        }

        return response()->json(['applications' => $applications->get()]);
    }

}
