<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;


class ApplicationLikeController extends Controller
{
    public function toggleLike($applicationId)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => 'unauthenticated',
                'message' => 'Увійдіть, щоб поставити лайк.'
            ], 401);
        }

        $application = Application::findOrFail($applicationId);

        if ($user->likedApplications()->where('application_id', $applicationId)->exists()) {
            $user->likedApplications()->detach($applicationId);
            return response()->json(['status' => 'removed']);
        } else {
            $user->likedApplications()->attach($applicationId);
            return response()->json(['status' => 'added']);
        }
    }
}
