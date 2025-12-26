<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cat;

class AdoptController extends Controller
{
    // Show all cats available for adoption
    public function index(Request $request)
    {
        $query = Cat::where('available', 1); // only available cats

        // Search filter
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('breed', 'like', '%' . $request->search . '%');
            });
        }

        // Gender filter
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // Breed filter
        if ($request->filled('breed')) {
            $query->where('breed', $request->breed);
        }

        // Age filter (assuming age is stored in years)
        if ($request->filled('age')) {
            switch ($request->age) {
                case 'kitten':
                    $query->where('age', '<=', 1);
                    break;
                case 'young':
                    $query->whereBetween('age', [1, 3]);
                    break;
                case 'adult':
                    $query->whereBetween('age', [3, 7]);
                    break;
                case 'senior':
                    $query->where('age', '>=', 7);
                    break;
            }
        }

        $cats = $query->get();
        return view('adopt.index', compact('cats'));
    }

    // Show single cat details
    public function show($id)
    {
        $cat = Cat::findOrFail($id);
        return view('adopt.show', compact('cat'));
    }
}