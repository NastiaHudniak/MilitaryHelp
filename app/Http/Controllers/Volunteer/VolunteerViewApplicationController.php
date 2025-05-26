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


class VolunteerViewApplicationController extends Controller
{
    public function index()
    {
        $users = User::all();
        $categories = Category::all();
        $applications = Application::with('images')
        ->whereNull('volunteer_id')
        ->get();
        $userLikedApplicationIds = auth()->check()
            ? auth()->user()->likedApplications()->pluck('application_id')->toArray()
            : [];


        return view('user.volunteer.view_app', compact('applications', 'users', 'categories', 'userLikedApplicationIds'));


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
        $sort = $request->input('sort');
        $user_id = Auth::user()->id;

        $applications = Application::with(['category', 'volunteer', 'millitary', 'images'])
            // ->when($user_id, function($q) use ($user_id) {
            //     $q->where('millitary_id', $user_id);
            // })
            ->whereNull('volunteer_id')
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


    public function generatePDF($id)
    {
        $application = Application::with(['category', 'volunteer', 'images'])->findOrFail($id);
        $pdf = Pdf::loadView('user.volunteer.pdf', compact('application'));

        return $pdf->download('application-' . $application->id . '.pdf');
    }

}
