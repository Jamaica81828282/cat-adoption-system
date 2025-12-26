<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cat;
use App\Models\Application;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard with stats and recent applications.
      */
    public function index()
{
    // Existing stats
    $totalCats = Cat::count();
    $totalApplications = Application::count();
    $users = User::where('is_admin', false)->get();
    
    // Cats status
    $availableCats = Cat::where('available', true)->count();
    $adoptedCats = Cat::where('available', false)->count();
    
    // Applications status
    $pendingApplications = Application::where('status', 'pending')->count();
    $approvedApplications = Application::where('status', 'approved')->count();
    
    // USER ENGAGEMENT METRICS
    $mostActiveUsers = User::where('is_admin', false)
        ->withCount('applications')
        ->orderBy('applications_count', 'desc')
        ->take(3)
        ->get();
    
    $newUsersThisWeek = User::where('is_admin', false)
        ->where('created_at', '>=', now()->startOfWeek())
        ->count();
    
    $newUsersLastWeek = User::where('is_admin', false)
        ->whereBetween('created_at', [
            now()->subWeek()->startOfWeek(),
            now()->subWeek()->endOfWeek()
        ])
        ->count();
    
    $userGrowthPercent = $newUsersLastWeek > 0 
        ? (($newUsersThisWeek - $newUsersLastWeek) / $newUsersLastWeek) * 100 
        : 0;
    
    $avgApplicationsPerCat = $totalCats > 0 
        ? round($totalApplications / $totalCats, 1) 
        : 0;
    
    $applicationsThisWeek = Application::where('created_at', '>=', now()->startOfWeek())
        ->count();
    
    return view('admin.dashboard', compact(
        'totalCats',
        'totalApplications',
        'users',
        'availableCats',
        'adoptedCats',
        'pendingApplications',
        'approvedApplications',
        'mostActiveUsers',
        'newUsersThisWeek',
        'userGrowthPercent',
        'avgApplicationsPerCat',
        'applicationsThisWeek'
    ));
}
    // public function index()
    // {
    //     $totalCats = Cat::count();
    //     $totalApplications = Application::count();
    //     $users = User::where('is_admin', false)->get();

    //     $applications = Application::with(['user', 'cat'])
    //         ->latest()
    //         ->get();

    //     return view('admin.dashboard', compact(
    //         'totalCats',
    //         'totalApplications',
    //         'users',
    //         'applications'
    //     ));
    // }

    /**
     * Show a separate page listing all applications.
     */
    public function applications()
    {
        $applications = Application::with(['user', 'cat'])
            ->latest()
            ->get();

        return view('admin.applications.index', compact('applications'));
    }

    public function updateStatus(Request $request, $id)
{
    $application = Application::findOrFail($id);
    $status = $request->input('status'); // 'approved' or 'declined'
    $application->status = $status;
    $application->save();

    // If approved, mark the cat as adopted
    if ($status === 'approved') {
        $cat = $application->cat;
        if ($cat) {
            $cat->available = false; // mark as adopted
            $cat->save();
        }
    }

    return redirect()->back()->with('message', "Application #{$id} has been {$status}.");
}
 
    /**
     * Update the status of an application.
     */
    // public function updateStatus(Request $request, $id)
    // {
    //     $application = Application::findOrFail($id);
    //     $status = $request->input('status'); // 'approved' or 'declined'
    //     $application->status = $status;
    //     $application->save();

    //     // If approved, mark the cat as adopted
    //     if ($status === 'approved') {
    //         $cat = $application->cat;
    //         if ($cat) {
    //             $cat->available = false; // mark as adopted
    //             $cat->save();
    //         }
    //     }

    //     return redirect()->back()->with('message', "Application #{$id} has been {$status}.");
    // }
}
