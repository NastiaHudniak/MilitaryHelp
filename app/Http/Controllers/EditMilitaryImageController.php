<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserImage;
use Illuminate\Http\Request;

class EditMilitaryImageController extends Controller
{
    public function edit(User $user)
    {
        $images = $user->images;
        return view('user.military.account.edit_photo', compact('user', 'images'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'new_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Завантаження та збереження нового фото
        if ($request->file('new_image')) {
            $path = $request->file('new_image')->store('user_images', 'public');
            UserImage::updateOrCreate(
                ['user_id' => $user->id],
                ['image_url' => $path]
            );
        }


        return redirect()->route('user.military.account.edit_photo', $user->id)->with('success', 'Фото оновлено успішно!');
    }
}
