<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
class ApplicationController extends Controller
{
    public function index()
    {
        $users = User::all();
        $categories = Category::all();

        $applications = Application::with(['category', 'volunteer', 'millitary'])->get();

        return view('admin.applications.index', compact('applications', 'users', 'categories'));
    }

    public function create()
    {
        $applications = Application::all();
        $users = User::all();
        $categories = Category::all();
        $volunteers = User::where('role_id', 3)->get();
        $militaries = User::where('role_id', 2)->get();

        return view('admin.applications.create', compact('applications','users','categories', 'volunteers', 'militaries'));
    }

    public function store(Request $request)
    {
        $messages = [
            'category_id.required' => '* Оберіть категорію.',
            'category_id.exists' => '* Обрана категорія не існує.',

            'volunteer_id.required' => '* Оберіть волонтера.',
            'volunteer_id.exists' => '* Обраний волонтер не існує.',

            'millitary_id.required' => '* Оберіть військового.',
            'millitary_id.exists' => '* Обраний військовий не існує.',

            'title.required' => '* Обов’язкове поле.',
            'title.string' => '* Назва повинна бути рядком.',
            'title.max' => '* Назва не може перевищувати 255 символів.',

            'description.required' => '* Обов’язкове поле.',
            'description.string' => '* Опис повинен бути рядком.',
            'description.max' => '* Опис не може перевищувати 1000 символів.',

            'status.required' => '* Оберіть статус.',
            'status.string' => '* Статус повинен бути рядком.',
            'status.max' => '* Статус не може перевищувати 255 символів.',

            'comment.string' => '* Коментар повинен бути рядком.',
            'comment.max' => '* Коментар не може перевищувати 1000 символів.',
        ];

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'volunteer_id' => 'required|exists:users,id',
            'millitary_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'status' => 'required|string|max:255',
            'comment' => 'nullable|string|max:1000',
        ], $messages);


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

        return redirect()->route('admin.applications.index')->with('success', 'Заявка створена успішно!');
    }

    public function edit($id)
    {
        $applications = Application::findOrFail($id);
        $categories = Category::all();
        $users = User::all();
        $volunteers = User::where('role_id', 3)->get();
    $militaries = User::where('role_id', 2)->get();
        return view('admin.applications.edit', compact('applications', 'categories', 'users', 'volunteers', 'militaries'));
    }

    public function update(Request $request, $id)
    {
        $applications = Application::findOrFail($id);
        $messages = [
            'category_id.required' => '* Оберіть категорію.',
            'category_id.exists' => '* Обрана категорія не існує.',

            'volunteer_id.required' => '* Оберіть волонтера.',
            'volunteer_id.exists' => '* Обраний волонтер не існує.',

            'millitary_id.required' => '* Оберіть військового.',
            'millitary_id.exists' => '* Обраний військовий не існує.',

            'title.required' => '* Обов’язкове поле.',
            'title.string' => '* Назва повинна бути рядком.',
            'title.max' => '* Назва не може перевищувати 255 символів.',

            'description.required' => '* Обов’язкове поле.',
            'description.string' => '* Опис повинен бути рядком.',
            'description.max' => '* Опис не може перевищувати 1000 символів.',

            'status.required' => '* Оберіть статус.',
            'status.string' => '* Статус повинен бути рядком.',
            'status.max' => '* Статус не може перевищувати 255 символів.',

            'comment.string' => '* Коментар повинен бути рядком.',
            'comment.max' => '* Коментар не може перевищувати 1000 символів.',
        ];
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'volunteer_id' => 'required|exists:users,id',
            'millitary_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'status' => 'required|string|max:255',
            'comment' => 'nullable|string|max:1000',
        ], $messages);

        $applications->update($validated);

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
        $applications = Application::with(['category', 'volunteer', 'millitary'])
            ->where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->get();

        return response()->json(['applications' => $applications]);
    }

    function filter(Request $request)
{
    $query = $request->input('query');
    $category = $request->input('category');
    $applications = Application::with(['category'])
        ->when($query, function ($q) use ($query) {
            $q->where('title', 'like', "%{$query}%")
              ->orWhere('description', 'like', "%{$query}%");
        })
        ->when($category, function($q) use ($category) {
            $q->where('category_id', $category);
        })
        ->get();

    return response()->json(['applications' => $applications]);
}

public function exportPDF()
    {
        $applications = Application::all();

        $totalApplications = $applications->count();
        $pdf = Pdf::loadView('admin.applications.pdf', compact('applications', 'totalApplications'));

        return $pdf->download('applications.pdf');
    }

}
