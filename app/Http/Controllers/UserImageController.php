<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserImage;
use Illuminate\Http\Request;

class UserImageController extends Controller
{
    public function create(User $user)
    {
        return view('admin.users.images.create', compact('user'));
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'image' => 'required|max:10240',
        ]);

        $imagePath = $request->file('image')->store('user_image', 'public');

        UserImage::create([
            'user_id' => $user->id,
            'image_url' => $imagePath,
        ]);

        return redirect()->route('admin.users.index', $user)->with('success', 'Зображення додано успішно !!!');
    }

}
