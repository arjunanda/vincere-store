<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Traits\DashboardHelpers;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    use DashboardHelpers;

    public function index(Request $request)
    {
        $query = Article::latest();

        if ($search = $request->search) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($type = $request->type) {
            $query->where('type', $type);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $articles = $query->paginate(15)->withQueryString();
        $articleTypes = Article::distinct()->pluck('type')->filter()->sort()->values();
        return view('dashboard.articles.index', compact('articles', 'articleTypes'));
    }

    public function create()
    {
        return view('dashboard.articles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'type'      => 'required|in:promo,berita',
            'image'     => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'content'   => 'required|string',
            'excerpt'   => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $data['slug']         = Str::slug($data['title']);
        $data['published_at'] = now();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadAndCompressImage($request->file('image'), 'articles');
        }

        Article::create($data);
        $this->logActivity('CREATE_ARTICLE', "Menulis artikel baru: {$data['title']}");

        return redirect()->route('dashboard.articles')->with('success', 'Artikel berhasil diterbitkan!');
    }

    public function edit(Article $article)
    {
        return view('dashboard.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'type'      => 'required|in:promo,berita',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'content'   => 'required|string',
            'excerpt'   => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $data['slug'] = Str::slug($data['title']);

        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $data['image'] = $this->uploadAndCompressImage($request->file('image'), 'articles');
        }

        $article->update($data);
        $this->logActivity('UPDATE_ARTICLE', "Memperbarui artikel: {$article->title}");

        return redirect()->route('dashboard.articles')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function toggleStatus(Article $article)
    {
        $article->update(['is_active' => !$article->is_active]);

        $status = $article->is_active ? 'diaktifkan' : 'dinonaktifkan';
        $this->logActivity('TOGGLE_ARTICLE_STATUS', "Mengubah status artikel {$article->title} menjadi {$status}");

        $msg = "Artikel berhasil $status!";
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => $msg, 'is_active' => $article->is_active]);
        }
        return back()->with('success', $msg);
    }

    public function destroy(Article $article)
    {
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $title = $article->title;
        $article->delete();
        $this->logActivity('DELETE_ARTICLE', "Menghapus artikel: {$title}");

        return back()->with('success', 'Artikel berhasil dihapus!');
    }
}
