<?php

namespace App\Http\Controllers\Military;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


class MilitaryViewApplicationController extends Controller
{
    public function index()
    {
        $users = User::all();
        $categories = Category::all();
        $user_id = Auth::user()->id;
        $applications = Application::with(['images', 'category', 'volunteer'])
            ->withCount('likedByUsers') // <-- додаємо підрахунок лайків
            ->where('millitary_id', $user_id)
            ->get();

        return view('user.military.view_app', compact('applications', 'users', 'categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'volunteer_id' => 'required|exists:users,id',
            'millitary_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'status' => 'required|string|max:255',
            'comment' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Application::create([
            'category_id' => $request->input('category_id'),
            'volunteer_id' => $request->input('volunteer_id'),
            'millitary_id' => $request->input('millitary_id'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->route('user.military.index')->with('success', 'Заявка створена успішно!');
    }

    public function edit($id)
    {
        $applications = Application::findOrFail($id);
        $categories = Category::all();
        $users = User::all();
        return view('user.military.edit', compact('applications', 'categories', 'users'));
    }

    public function update(Request $request, $id)
    {
        $applications = Application::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        $applications->update($validated);

        return redirect()->route('user.military.view_app')->with('success', 'Заявка оновлена успішно!');
    }

    public function destroy(Application $applications)
    {
        $applications->delete();
        return redirect()->route('user.military.view_app')->with('error', 'Заявка видалена успішно!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category');
        $status = $request->input('status');
        $sort = $request->input('sort');
        $user_id = Auth::user()->id;

        if($status == "created") $status = "створено";
        if($status == "accept") $status = "прийнято";
        if($status == "cancel") $status = "відхилено";

        $applications = Application::with(['category', 'volunteer', 'millitary', 'images'])
            // ->when($user_id, function($q) use ($user_id) {
            //     $q->where('millitary_id', $user_id);
            // })
            ->where('millitary_id', $user_id)
            // ->where('category_id', $category)
            ->when(!is_null($category), function($q) use ($category) {
                $q->where('category_id', $category);
            })
            ->when(!is_null($status), function($q) use ($status) {
                $q->where('status', $status);
            })
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%");
            });

        if ($sort === 'latest') {
            $applications->orderBy('created_at', 'desc');
        } elseif ($sort === 'oldest') {
            $applications->orderBy('created_at', 'asc');
        } elseif ($sort === 'status') {
            $applications->orderBy('status', 'asc');
        }

        return response()->json(['applications' => $applications->get()]);
    }

    public function generatePDF($id)
    {
        $application = Application::with(['category', 'volunteer', 'images'])->findOrFail($id);
        $pdf = Pdf::loadView('user.military.pdf', compact('application'));
        //return view('user.military.pdf', compact('application'));
        return $pdf->download('application-'.$application->id.'.pdf');


    }

    public function exportAllApplicationsToPDF()
    {
        $user = Auth::user(); // військовий

        $applications = \App\Models\Application::with(['category', 'volunteer', 'images'])
            ->where('millitary_id', $user->id)
            ->get();

        $applicationCount = $applications->count();
        $date = \Carbon\Carbon::now()->format('d.m.Y');
        $fullName = $user->surname . ' ' . $user->name;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('user.military.all_applications_pdf', compact('applications', 'applicationCount', 'date', 'fullName'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('all_applications_'.$user->id.'.pdf');
    }
    public function exportApplicationsToCSV()
    {
        $user = Auth::user(); // військовий
        $applications = $user->applications()->with(['category', 'volunteer', 'images'])->get();

        $filename = 'applications_' . $user->id . '_' . date('Y-m-d') . '.csv';

        // Відкриваємо потік для виводу
        $handle = fopen('php://output', 'w');

        // Заголовки стовпців
        $headers = ['№', 'Назва заявки', 'Опис', 'Категорія', 'Волонтер', 'Кількість фото'];
        // Відправляємо заголовок для завантаження файлу
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        // Записуємо заголовки
        fputcsv($handle, $headers);

        $counter = 1;
        foreach ($applications as $app) {
            fputcsv($handle, [
                $counter,
                $app->title,
                $app->description,
                $app->category?->name ?? '',
                $app->volunteer?->name ?? '',
                $app->images->count(),
            ]);
            $counter++;
        }

        fclose($handle);
        exit;
    }


}
