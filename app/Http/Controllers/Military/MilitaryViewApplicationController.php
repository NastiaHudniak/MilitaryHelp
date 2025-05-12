<?php

namespace App\Http\Controllers\Military;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Barryvdh\DomPDF\Facade\Pdf;


class MilitaryViewApplicationController extends Controller
{
    public function index()
    {
        $users = User::all();
        $categories = Category::all();
        $user_id = Auth::user()->id;
        $applications = Application::with('images')
        ->where('millitary_id',  $user_id)->get();
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
        $category = $request->input('category');
        $status = $request->input('status');
        $sort = $request->input('sort');
        $user_id = Auth::user()->id;

        if($status == "created") $status = "створено";
        if($status == "accept") $status = "прийнято";
        if($status == "cancel") $status = "відхилено";

        $applications = Application::with(['category', 'volunteer', 'millitary', 'images'])
            // ->when($user_id, function($q) use ($user_id) {
            //     $q->where('millitary_id', $user_id);
            // })
            ->where('millitary_id', $user_id)
            // ->where('category_id', $category)
            ->when(!is_null($category), function($q) use ($category) {
                $q->where('category_id', $category);
            })
            ->when(!is_null($status), function($q) use ($status) {
                $q->where('status', $status);
            })
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%");
            });

        if ($sort === 'latest') {
            $applications->orderBy('created_at', 'desc');
        } elseif ($sort === 'oldest') {
            $applications->orderBy('created_at', 'asc');
        } elseif ($sort === 'status') {
            $applications->orderBy('status', 'asc');
        }

        return response()->json(['applications' => $applications->get()]);
    }

    public function generatePDF($id)
    {
        $application = Application::with('images')->findOrFail($id);
        $pdf = Pdf::loadView('user.military.pdf', compact('application'));

        return $pdf->download('application-'.$application->id.'.pdf');
    }

}
