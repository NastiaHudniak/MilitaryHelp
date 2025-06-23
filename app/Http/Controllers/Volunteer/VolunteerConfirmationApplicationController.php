<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VolunteerConfirmationApplicationController extends Controller
{
    public function index($id)
    {
        $application = Application::with('images')
        ->findOrFail($id);

        $millitary = User::with('images')->findOrFail($application->millitary_id);
        $userImage = $millitary->images()->first();
        return view('user.volunteer.confirm_application', [
            'millitary' => $millitary,
            'application' => $application,
            'userImage' => $userImage
        ]);
    }

    public function confirm(Request $request, $id)
    {
        $application = Application::findOrFail($id);

        if ($request->has('comment') && !empty($request->comment)) {
            $application->comment = $request->comment;
        }

        $application->status = 'прийнято';
        $application->volunteer_id = Auth::id();
        $application->save();
        return redirect()->route('user.volunteer.confirm.view_confirm_app')->with('success', 'Заявку підтверджено.');
    }
}
