<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Application;
use App\Models\ApplicationImage;

class ApplicationImageController extends Controller
{
    public function create(Application $application)
    {
        return view('admin.applications.images.create', compact('application'));
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

        return redirect()->route('admin.applications.index', $application)->with('success', 'Зображення додано успішно !!!');
    }

    public function edit(Application $application)
    {
        $images = $application->images;
        return view('admin.applications.images.edit', compact('application', 'images'));
    }

    public function destroy(Application $application, ApplicationImage $image)
    {
        if ($image->image_url && Storage::disk('public')->exists($image->image_url)) {
            Storage::disk('public')->delete($image->image_url);
        }
        $image->delete();

        return redirect()->route('admin.applications.images.edit', ['applications' => $applications->id])->with('error', 'Зображення видалено успішно !!!');
    }


}
