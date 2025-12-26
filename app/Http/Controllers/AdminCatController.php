<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminCatController extends Controller
{
    // Show all cats (admin view)
    public function index()
    {
        $cats = Cat::latest()->get(); // Show newest first
        return view('admin.cat.index', compact('cats'));
    }

    // Show form to create a new cat
    public function create()
    {
        return view('admin.cat.create');
    }

    // Store new cat in database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|numeric|min:0',
            'breed' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $cat = new Cat();
        $cat->name = $request->name;
        $cat->age = $request->age;
        $cat->breed = $request->breed;
        $cat->gender = $request->gender;
        $cat->description = $request->description;
        $cat->available = $request->has('available') ? 1 : 0;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('cats', 'public');
            // Remove leading slash if Laravel adds one
            $cat->image = ltrim($path, '/');
        }

        $cat->save();

        return redirect()->route('admin.cats.index')
                         ->with('success', '🎉 ' . $cat->name . ' has been added successfully!');
    }

    // Show form to edit a cat
    public function edit($id)
    {
        $cat = Cat::findOrFail($id);
        return view('admin.cat.edit', compact('cat'));
    }

    // Update cat in database
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|numeric|min:0',
            'breed' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $cat = Cat::findOrFail($id);
        $cat->name = $request->name;
        $cat->age = $request->age;
        $cat->breed = $request->breed;
        $cat->gender = $request->gender;
        $cat->description = $request->description;
        $cat->available = $request->has('available') ? 1 : 0;

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image using Storage facade
            if ($cat->image && Storage::disk('public')->exists($cat->image)) {
                Storage::disk('public')->delete($cat->image);
            }
            
            $path = $request->file('image')->store('cats', 'public');
            // Remove leading slash if Laravel adds one
            $cat->image = ltrim($path, '/');
        }

        $cat->save();

        return redirect()->route('admin.cats.index')
                         ->with('success', '✨ ' . $cat->name . ' has been updated successfully!');
    }

    // Delete a cat from database
    public function destroy($id)
    {
        $cat = Cat::findOrFail($id);
        $catName = $cat->name;

        // Delete image using Storage facade
        if ($cat->image && Storage::disk('public')->exists($cat->image)) {
            Storage::disk('public')->delete($cat->image);
        }

        $cat->delete();

        return redirect()->route('admin.cats.index')
                         ->with('success', '🗑️ ' . $catName . ' has been removed from the system.');
    }

    // Toggle cat availability (adopted / available)
    public function updateStatus($id)
    {
        $cat = Cat::findOrFail($id);
        $cat->available = !$cat->available;
        $cat->save();

        if (!$cat->available) {
            session()->flash('adopted_cat', '🎉 ' . $cat->name . ' has been marked as adopted!');
        } else {
            session()->flash('success', '✅ ' . $cat->name . ' is now available for adoption!');
        }

        return redirect()->route('admin.cats.index');
    }
}