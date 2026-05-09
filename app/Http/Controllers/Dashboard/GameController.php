<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Traits\DashboardHelpers;
use App\Models\Game;
use App\Models\Category;
use App\Models\InputGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GameController extends Controller
{
    use DashboardHelpers;

    public function index(Request $request)
    {
        $query = Game::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $games      = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::all();

        return view('dashboard.games.index', compact('games', 'categories'));
    }

    public function create()
    {
        $categories  = Category::all();
        $inputGroups = InputGroup::all();
        return view('dashboard.games.create', compact('categories', 'inputGroups'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'input_group_id' => 'required|exists:input_groups,id',
            'name'           => 'required|string|max:255',
            'image'          => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'platform_type'  => 'required|in:mobile,pc,console',
            'description'    => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadAndCompressImage($request->file('image'), 'games');
        }

        $data['slug'] = $this->generateUniqueSlug($data['name']);
        Game::create($data);

        $this->logActivity('CREATE_GAME', "Menambahkan game baru: {$data['name']}");

        return redirect()->route('dashboard.games')->with('success', 'Game berhasil ditambahkan!');
    }

    public function edit(Game $game)
    {
        $categories  = Category::all();
        $inputGroups = InputGroup::all();
        return view('dashboard.games.edit', compact('game', 'categories', 'inputGroups'));
    }

    public function update(Request $request, Game $game)
    {
        $data = $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'input_group_id' => 'required|exists:input_groups,id',
            'name'           => 'required|string|max:255',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'platform_type'  => 'required|in:mobile,pc,console',
            'description'    => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadAndCompressImage($request->file('image'), 'games');
        }

        $data['slug'] = $this->generateUniqueSlug($data['name'], $game->id);
        $game->update($data);

        $this->logActivity('UPDATE_GAME', "Memperbarui data game: {$game->name}");

        return redirect()->route('dashboard.games')->with('success', 'Game berhasil diperbarui!');
    }

    public function toggleStatus(Game $game)
    {
        $game->update(['is_active' => !$game->is_active]);

        $status = $game->is_active ? 'diaktifkan' : 'dinonaktifkan';
        $this->logActivity('TOGGLE_GAME_STATUS', "Mengubah status game {$game->name} menjadi {$status}");

        $msg = "Game $game->name berhasil $status!";
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => $msg, 'is_active' => $game->is_active]);
        }
        return back()->with('success', $msg);
    }

    public function destroy(Game $game)
    {
        $name = $game->name;
        $game->delete();
        $this->logActivity('DELETE_GAME', "Menghapus game: {$name}");
        return back()->with('success', 'Game berhasil dihapus!');
    }
    private function generateUniqueSlug($name, $ignoreId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (Game::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }
}
