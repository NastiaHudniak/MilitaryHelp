<?php

namespace App\Http\Controllers\Military;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ApplicationImage;
use Illuminate\Support\Facades\Storage;

class MilitaryApplicationImageController extends Controller
{
    public function create(Application $application)
    {
        return view('user.military.images.create', compact('application'));
    }

    public function store(Request $request, Application $application)
    {
        $messages = [
            'image.required' => '* Обов`язкове поле.',
            'image.max' => '* Зображення не може бути більшим за 10 МБ.',
            'image.file' => '* Файл повинен бути зображенням.',
        ];
        $request->validate([
            'image' => 'required|max:10240',
        ], $messages);

        $imagePath = $request->file('image')->store('application_image', 'public');

        ApplicationImage::create([
            'application_id' => $application->id,
            'image_url' => $imagePath,
        ]);

        return redirect()->route('user.military.view_app', $application)->with('success', 'Зображення додано успішно !!!');
    }

    public function edit(Application $application)
    {
        $images = $application->images;
        return view('user.military.images.edit', compact('application', 'images'));
    }

    public function destroy(Application $application, ApplicationImage $image)
    {
        if ($image->image_url && Storage::disk('public')->exists($image->image_url)) {
            Storage::disk('public')->delete($image->image_url);
        }
        $image->delete();

        return redirect()->route('user.military.images.edit', ['application ' => $application->id])->with('error', 'Зображення видалено успішно !!!');
    }


}
