<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EditMilitaryImageController extends Controller
{
    public function edit(User $user)
    {
        $images = $user->images;
        return view('user.military.account.edit_photo', compact('user', 'images'));
    }

    public function destroy(User $user, UserImage $image)
    {
        if ($image->image_url && Storage::disk('public')->exists($image->image_url)) {
            Storage::disk('public')->delete($image->image_url);
        }
        $image->delete();

        return redirect()->route('user.military.account.edit_photo', ['user' => $user->id])->with('error', 'Зображення видалено успішно !!!');
    }
}
