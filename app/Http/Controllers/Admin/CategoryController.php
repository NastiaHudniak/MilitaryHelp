<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Barryvdh\DomPDF\Facade\Pdf;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => '* Обов`язкове поле.',
            'name.max' => '* Логін не може містити більше ніж 255 символів.',

        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Category::create([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Категорія створена успішно!');
    }

    public function edit($id)
    {
        $categories = Category::findOrFail($id);
        return view('admin.categories.edit', compact('categories'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Категорія оновлена успішно!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('error', 'Категорія видалена успішно!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Пошук категорій за назвою
        $categories = Category::where('name', 'like', "%{$query}%")->get();

        return response()->json(['categories' => $categories]);
    }


    public function exportPDF()
    {
        $categories = Category::all();

        $totalCategories = $categories->count();

        $pdf = Pdf::loadView('admin.categories.pdf', compact('categories', 'totalCategories'));

        return $pdf->download('categories.pdf');
    }


}
