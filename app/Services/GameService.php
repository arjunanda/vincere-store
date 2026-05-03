<?php

namespace App\Services;

use App\Models\Game;
use App\Models\Category;
use App\Models\Transaction;

class GameService
{
    /**
     * Mengambil data untuk dashboard overview
     */
    public function getDashboardStats($user_id = null)
    {
        $transactionQuery = Transaction::query();
        
        if ($user_id) {
            $transactionQuery->where('user_id', $user_id);
        }

        return [
            'total_revenue' => (clone $transactionQuery)->whereIn('payment_status', ['paid', 'success', 'completed'])->sum('total_price'),
            'total_orders' => (clone $transactionQuery)->count(),
            'active_games' => Game::where('is_active', true)->count(),
            'recent_transactions' => $transactionQuery->with(['game', 'user'])
                                    ->latest()
                                    ->take(5)
                                    ->get()
        ];
    }

    /**
     * Mengambil daftar game beserta kategorinya
     */
    public function getAllGames()
    {
        return Game::with('category')->latest()->get();
    }

    /**
     * Mengambil detail game beserta variant harganya dan input templatenya
     */
    public function getGameDetails(string $slug)
    {
        return Game::where('slug', $slug)
            ->with(['variants', 'inputGroup.fields', 'category'])
            ->firstOrFail();
    }
}
