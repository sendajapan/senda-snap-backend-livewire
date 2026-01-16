<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function taskStats(): JsonResponse
    {
        $stats = [
            'pending' => Task::where('status', 'pending')->count(),
            'running' => Task::where('status', 'running')->count(),
            'completed' => Task::where('status', 'completed')->count(),
            'cancelled' => Task::where('status', 'cancelled')->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'stats' => $stats,
            ],
        ]);
    }
}
