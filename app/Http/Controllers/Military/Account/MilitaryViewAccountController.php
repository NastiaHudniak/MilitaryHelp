<?php

namespace App\Http\Controllers\Military\Account;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MilitaryViewAccountController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('role'); 
        $userImage = $user->images()->first();
        $totalApplications = Application::where('millitary_id', $user->id)->count();
        $acceptedApplications = Application::where('millitary_id', $user->id)
            ->whereNotNull('volunteer_id')
            ->count();

        return view('user.military.view_account', compact('user', 'totalApplications', 'acceptedApplications', 'userImage'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|unique:users|max:255',
            'surname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'login' => $request->input('login'),
            'surname' => $request->input('surname'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'role_id' => $request->input('role_id'),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Користувач створений успішно !!!');
    }





//    public function edit($id)
//    {
//        $user = User::findOrFail($id);
//        $roles = Role::all();
//        return view('admin.users.edit', compact('user', 'roles'));
//    }
//
//    public function update(Request $request, $id)
//    {
//        $user = User::findOrFail($id);
//        $isLoginChanged = $user->login !== $request->input('login');
//
//        $validated = $request->validate([
//            'login' => [
//                'required',
//                'string',
//                'max:255',
//                $isLoginChanged ? 'unique:users,login' : 'nullable',
//            ],
//            'surname' => 'required|string|max:255',
//            'name' => 'required|string|max:255',
//            'email' => 'required|email|unique:users,email,' . $id,
//            'phone' => 'required|string|max:255',
//            'address' => 'required|string|max:255',
//            'role_id' => 'required|exists:roles,id',
//        ]);
//
//        $user->update([
//            'login' => $validated['login'] ?? $user->login,
//            'surname' => $validated['surname'],
//            'name' => $validated['name'],
//            'email' => $validated['email'],
//            'phone' => $validated['phone'],
//            'address' => $validated['address'],
//            'role_id' => $validated['role_id'],
//        ]);
//
//        return redirect()->route('admin.users.index')->with('success', 'Данні користувача оновлено успішно !!!');
//    }

//    public function destroy(User $user)
//    {
//        $user->delete();
//        return redirect()->route('admin.users.index')->with('error', 'Користувача успішно видалено !!!');
//    }
//
//    public function search(Request $request)
//    {
//        $query = $request->input('query');
//        $users = User::where('login', 'like', "%{$query}%")->with('role')->get();
//
//        return response()->json(['users' => $users]);
//    }
//
//    public function filter(Request $request)
//    {
//        $query = $request->input('query');
//        $role = $request->input('role');
//        $users = User::with('role')
//            ->when($query, function($queryBuilder) use ($query) {
//                $queryBuilder->where('login', 'like', "%{$query}%");
//            })
//            ->when($role, function($queryBuilder) use ($role) {
//                $queryBuilder->where('role_id', $role);
//            })
//            ->get();
//
//        return response()->json(['users' => $users]);
//    }
}
