<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        if ($userId = $request->user_id) {
            $query->where('user_id', $userId);
        }

        $logs = $query->paginate(20)->withQueryString();
        $admins = User::where('role', 'admin')->orderBy('name')->get();
        return view('dashboard.logs.index', compact('logs', 'admins'));
    }
}
