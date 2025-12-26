<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use Illuminate\Http\Request;

class CatController extends Controller
{
    /**
     * Admin: Show all cats in Manage Cats page
     */
    public function index()
    {
        $cats = Cat::all(); // admin sees all cats
        return view('admin.cat.index', compact('cats')); // make sure the view path is correct
    }

    /**
     * Admin: Toggle cat availability manually
     */
    public function updateStatus($id)
    {
        $cat = Cat::findOrFail($id);

        // Toggle availability
        $cat->available = !$cat->available;
        $cat->save();

        // Flash message if marked as adopted
        if (!$cat->available) {
            session()->flash('adopted_cat', $cat->name);
        }

        return redirect()->route('admin.cats.index'); // matches the admin route
    }

    /**
     * User: Show single cat details
     */
    public function show(Cat $cat)
    {
        return view('cats.show', compact('cat')); // user-facing view
    }

    /**
     * User: Show all available cats for adoption
     */
    public function availableCats()
    {
        $cats = Cat::where('available', true)->get(); // only show available cats
        return view('adopt.index', compact('cats')); // user-facing adopt list
    }
}
