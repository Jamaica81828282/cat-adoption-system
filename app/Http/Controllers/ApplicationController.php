<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Models\Cat;

class ApplicationController extends Controller
{
    // Show the user's applications
    public function index()
    {
        // Load all applications for the logged-in user, including cat info
        $applications = Application::where('user_id', Auth::id())
                                   ->with('cat')
                                   ->orderBy('created_at', 'desc') // newest first
                                   ->get();

        return view('applications.index', compact('applications'));
    }

    // Show a single application (for approved applications)
    public function show($id)
    {
        $application = Application::where('id', $id)
                                  ->where('user_id', Auth::id())
                                  ->with('cat')
                                  ->firstOrFail();

        return view('applications.show', compact('application'));
    }

    // Show the adoption application form for a specific cat
    public function create($catId)
    {
        $cat = Cat::find($catId);

        if (!$cat) {
            abort(404);
        }

        return view('applications.create', compact('cat'));
    }

    // Store the adoption application
    public function store(Request $request, $catId)
    {
        // Prevent duplicate applications
        if (Application::where('user_id', Auth::id())->where('cat_id', $catId)->exists()) {
            return redirect()->back()->withErrors(['error' => 'You already applied for this cat!']);
        }

        // Validate the request
        $validated = $request->validate([
            'notes' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:gcash,paymaya,bank_transfer,cash',
            'payment_reference' => 'required_unless:payment_method,cash|nullable|string|max:100',
        ]);

        // Create the application
        $application = Application::create([
            'user_id' => Auth::id(),
            'cat_id' => $catId,
            'notes' => $validated['notes'] ?? null,
            'payment_method' => $validated['payment_method'],
            'payment_reference' => $validated['payment_reference'] ?? null,
            'fee' => 25,
            'payment_status' => 'pending',
            'status' => 'pending',
        ]);

        // Redirect to My Applications with a success message
        $paymentMethodDisplay = ucwords(str_replace('_', ' ', $validated['payment_method']));

        return redirect()->route('applications.index')
            ->with('success', "Application submitted successfully! Please complete your payment of ₱25.00 via {$paymentMethodDisplay}.");
    }
}