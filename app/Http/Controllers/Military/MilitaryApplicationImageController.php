<?php

namespace App\Http\Controllers\Military;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ApplicationImage;

class MilitaryApplicationImageController extends Controller
{
    public function create(Application $application)
    {
        return view('user.military.images.create', compact('application'));
    }

    public function store(Request $request, Application $application)
    {
        $request->validate([
            'image' => 'required|max:10240',
        ]);

        $imagePath = $request->file('image')->store('application_image', 'public');

        ApplicationImage::create([
            'application_id' => $application->id,
            'image_url' => $imagePath,
        ]);

        return redirect()->route('user.military.index', $application)->with('success', 'Зображення додано успішно !!!');
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

        return redirect()->route('user.military.images.edit', ['applications' => $applications->id])->with('error', 'Зображення видалено успішно !!!');
    }


}
