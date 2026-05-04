<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Article;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $games = Game::where('is_active', true)->get();
        $articles = Article::whereNotNull('published_at')->get();

        return response()->view('sitemap', [
            'games' => $games,
            'articles' => $articles,
        ])->header('Content-Type', 'text/xml');
    }
}
