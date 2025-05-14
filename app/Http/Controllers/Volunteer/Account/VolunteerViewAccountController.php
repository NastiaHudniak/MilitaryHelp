<?php

namespace App\Http\Controllers\Volunteer\Account;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Role;
use App\Models\User;
use App\Models\VolunteerRating;

class VolunteerViewAccountController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('role');
        $userImage = $user->images()->first();
        $totalApplications = Application::where('volunteer_id', $user->id)->count();

        $ratings = VolunteerRating::where('user_id', $user->id)->pluck('rating');

        // Якщо є рейтинги, обчислюємо середнє значення
        $averageRating = $ratings->isNotEmpty() ? $ratings->average() : null;

        return view('user.volunteer.view_account', compact('user', 'userImage',  'totalApplications', 'averageRating'));
    }

    public function edit(User $user)
    {
        $images = $user->images;
        return view('admin.products.images.edit', compact('user','images'));
    }

    public function destroy(User $user, UserImage $image)
    {
        if ($image->image_url && Storage::disk('public')->exists($image->image_url)) {
            Storage::disk('public')->delete($image->image_url);
        }
        $image->delete();

        return redirect()->route('admin.products.images.edit', ['user' => $user->id])->with('error', 'Зображення видалено успішно !!!');
    }

}
