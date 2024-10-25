<?php

namespace App\Http\Controllers\Volunteer\Account;

use App\Http\Controllers\Controller;

class VolunteerViewAccountController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('role'); // Отримуємо авторизованого користувача з роллю
//        // Отримати загальну кількість заявок авторизованого користувача
//        $totalApplications = Application::where('millitary_id', $user->id)->count();
//
//        // Отримати кількість прийнятих заявок (де volunteer_id не є порожнім)
//        $acceptedApplications = Application::where('millitary_id', $user->id)
//            ->whereNotNull('volunteer_id')
//            ->count();

        return view('user.volunteer.view_account', compact('user'));
    }

    public function edit(User $user)
    {
        $images = $user->images;
        return view('admin.products.images.edit', compact('user', 'images'));
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
