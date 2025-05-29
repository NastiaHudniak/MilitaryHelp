<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FavoriteUserController extends Controller
{
    // FavoriteUserController.php

    public function toggle(User $user)
    {
        $authUser = auth()->user();

        if (! $authUser) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if ($authUser->favorites()->toggle($user->id)) {
            $status = $authUser->favorites->contains($user->id) ? 'added' : 'removed';
            return response()->json(['status' => $status]);
        }

        return response()->json(['message' => 'Не вдалося змінити обране.'], 500);
    }


}
