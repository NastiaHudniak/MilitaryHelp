<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MilitaryHomeController extends Controller
{
    // Метод для відображення сторінки користувачів
    public function index()
    {
        return view('user.military.index'); // Повертає шаблон admin.users
    }

    // Метод для відображення сторінки заявок
    public function applications()
    {
        return view('admin.applications'); // Повертає шаблон admin.applications
    }
}
