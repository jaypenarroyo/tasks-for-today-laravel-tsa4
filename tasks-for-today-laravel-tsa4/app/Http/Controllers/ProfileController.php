<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Public Profile page: displays the logged-in user or the default seeded user record.
     */
    public function show(): View
    {
        $user = Auth::user() ?? User::first();

        $taskSummary = [
            'total' => Task::active()->count(),
            'today' => Task::forToday()->count(),
            'pending' => Task::active()->pending()->count(),
            'done' => Task::active()->done()->count(),
            'archived' => Task::archived()->count(),
        ];

        return view('profile.show', [
            'user' => $user,
            'taskSummary' => $taskSummary,
        ]);
    }
}
