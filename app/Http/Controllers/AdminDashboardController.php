<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Cat;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Fetch all applications (if you have an Application model)
        $applications = Application::with(['user', 'cat'])->get();

        // Count total cats
        $totalCats = Cat::count();

        return view('admin.dashboard', compact('applications', 'totalCats'));
    }
}
