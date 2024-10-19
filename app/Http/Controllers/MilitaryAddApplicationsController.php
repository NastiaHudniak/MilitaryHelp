<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MilitaryAddApplicationsController extends Controller
{
    public function index()
    {
        $users = User::all();
        $categories = Category::all();
        $applications = Application::all();
        return view('user.military.index', compact('applications','users', 'categories'));
    }

    public function create()
    {
        $applications = Application::all();
        $users = User::all();
        $categories = Category::all();
        return view('user.military.create', compact('applications','users','categories'));
    }

   public function store(Request $request)
   {
       $validator = Validator::make($request->all(), [
           'category_id' => 'required|exists:categories,id',
           'title' => 'required|string|max:255',
           'description' => 'required|string|max:255',
           ]);

       if ($validator->fails()) {
           return redirect()->back()->withErrors($validator)->withInput();
       }

       Application::create([
           'category_id' => $request->input('category_id'),
           'title' => $request->input('title'),
           'description' => $request->input('description'),
           'status' => 'створено', // Автоматично встановлюємо статус
           'millitary_id' => auth()->user()->id, // ID авторизованого військового
           'volunteer_id' => null, // Volunteer не обраний, вставляємо null
           'comment' => $request->input('comment', 'немає'), // Якщо коментаря немає, встановлюємо значення "немає"
       ]);
       return redirect()->route('user.military.index')->with('success', 'Заявка успішно створена');
   }


//    public function edit($id)
//    {
//        $applications = Application::findOrFail($id);
//        $categories = Category::all();
//        $users = User::all();
//        return view('admin.applications.edit', compact('applications', 'categories', 'users'));
//    }
//
//    public function update(Request $request, $id)
//    {
//        $applications = Application::findOrFail($id);
//
//        $validated = $request->validate([
//            'category_id' => 'required|exists:categories,id',
//            'volunteer_id' => 'required|exists:users,id',
//            'millitary_id' => 'required|exists:users,id',
//            'title' => 'required|string|max:255',
//            'description' => 'required|string|max:1000',
//            'status' => 'required|string|max:255',
//            'comment' => 'nullable|string|max:1000',
//        ]);
//
//        $applications->update($validated);
//
//        return redirect()->route('user.military.index')->with('success', 'Заявка оновлена успішно!');
//    }
//
//    public function destroy(Application $applications)
//    {
//        $applications->delete();
//        return redirect()->route('user.military.index')->with('error', 'Заявка видалена успішно!');
//    }
//
//    public function search(Request $request)
//    {
//        $query = $request->input('query');
//        $applications = Application::with(['category', 'volunteer', 'millitary'])
//            ->where('title', 'like', "%{$query}%")
//            ->orWhere('description', 'like', "%{$query}%")
//            ->get();
//
//        return response()->json(['applications' => $applications]);
//    }
//
//    public function filter(Request $request)
//    {
//        $query = $request->input('query');
//        $category = $request->input('category_id');
//        $status = $request->input('status');
//
//        $applications = Application::with(['category', 'volunteer', 'millitary'])
//            ->when($query, function($queryBuilder) use ($query) {
//                $queryBuilder->where('title', 'like', "%{$query}%")
//                    ->orWhere('description', 'like', "%{$query}%");
//            })
//            ->when($category, function($queryBuilder) use ($category) {
//                $queryBuilder->where('category_id', $category);
//            })
//            ->when($status, function($queryBuilder) use ($status) {
//                $queryBuilder->where('status', $status);
//            })
//            ->get();
//
//        return response()->json(['applications' => $applications]);
//    }
}
