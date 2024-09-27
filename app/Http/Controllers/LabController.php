<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class LabController extends Controller
{
    public function index()
    {
        $data = ['name' => 'Анастасія', 'role' => 'Студентка'];
        return view('welcome', $data);
    }

    public function about()
    {
        $data = [
            'name' => 'Анастасія',
            'role' => 'Студентка',
            'description' => 'Навчаюсь на 4 курсі політехнічного коледжу'];
        return view('about', $data);
    }

    public function contact()
    {
        $data = ['email' => 'nastiahudniak@gmail.com', 'phone' => '+380677146544'];
        return view('contact', $data);
    }

    public function hobbies()
    {
        $hobbies = ['Малювання', 'Дизайн', 'Подорожі', 'Читання'];
        return view('hobbies', compact('hobbies'));
    }

    public function main()
    {
        return view('main');
    }


}
