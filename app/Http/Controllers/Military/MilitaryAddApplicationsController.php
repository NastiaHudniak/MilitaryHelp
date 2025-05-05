<?php

namespace App\Http\Controllers\Military;

use App\Http\Controllers\Controller;
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
           'status' => 'створено', 
           'millitary_id' => auth()->user()->id, 
           'volunteer_id' => null, 
           'comment' => $request->input('comment', 'немає'), 
       ]);
       return redirect()->route('user.military.index')->with('success', 'Заявка успішно створена');
   }
}
