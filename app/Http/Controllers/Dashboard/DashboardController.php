<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\GameService;

class DashboardController extends Controller
{
    protected $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function index()
    {
        $userId = auth()->user()->role === 'admin' ? null : auth()->id();
        $stats = $this->gameService->getDashboardStats($userId);
        return view('dashboard.index', compact('stats'));
    }

    public function myOrders()
    {
        return view('dashboard.my-orders.index');
    }

    public function topup()
    {
        return view('dashboard.topup.index');
    }
}
