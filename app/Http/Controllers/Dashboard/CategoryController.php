<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Traits\DashboardHelpers;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use DashboardHelpers;

    public function index()
    {
        $categories = Category::withCount('games')->latest()->paginate(10);
        return view('dashboard.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $data['slug'] = Str::slug($data['name']);
        Category::create($data);

        $this->logActivity('CREATE_CATEGORY', "Menambahkan kategori: {$data['name']}");
        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $data['slug'] = Str::slug($data['name']);
        $category->update($data);

        $this->logActivity('UPDATE_CATEGORY', "Memperbarui kategori: {$data['name']}");
        return back()->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Category $category)
    {
        if ($category->games()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki game tertaut.');
        }

        $name = $category->name;
        $category->delete();

        $this->logActivity('DELETE_CATEGORY', "Menghapus kategori: {$name}");
        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}
