<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Application;

class AdminRecentApplications extends Component
{
    public $applications;

    public function mount()
    {
        $this->loadApplications();
    }

    public function loadApplications()
    {
        $this->applications = Application::with(['user', 'cat'])
            ->latest()
            ->take(10)
            ->get();
    }

    // Auto-refresh every 10 seconds
    public function render()
    {
        return view('livewire.admin-recent-applications');
    }
}
