<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        $messageText = $request->message;
        $subject = 'Нове повідомлення зі зворотнього зв\'язку';
        $toEmail = 'nastiahudniak@gmail.com';

        if ($user) {
            $userInfo = "Від: {$user->surname} {$user->name} (роль: {$user->role->name})";
        } else {
            $userInfo = "Від: неавторизованого користувача";
        }

        $fullMessage = $userInfo . "\n\nПовідомлення:\n" . $messageText;

        Mail::raw($fullMessage, function ($message) use ($toEmail, $subject) {
            $message->to($toEmail)->subject($subject);
        });

        return response()->json(['success' => 'Повідомлення надіслано!']);


    }
}
