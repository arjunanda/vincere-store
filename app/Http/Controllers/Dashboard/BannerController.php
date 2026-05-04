<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Traits\DashboardHelpers;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    use DashboardHelpers;

    public function index(Request $request)
    {
        $query = Banner::orderBy('order_position');

        if ($search = $request->search) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $banners = $query->paginate(15)->withQueryString();
        return view('dashboard.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('dashboard.banners.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'nullable|string|max:255',
            'image'          => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link'           => 'nullable|string|max:255',
            'order_position' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadAndCompressImage($request->file('image'), 'banners');
        }

        Banner::create($data);
        $this->logActivity('CREATE_BANNER', "Menambahkan banner baru: " . ($data['title'] ?? 'Tanpa Judul'));

        return redirect()->route('dashboard.banners')->with('success', 'Banner berhasil ditambahkan!');
    }

    public function edit(Banner $banner)
    {
        return view('dashboard.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $data = $request->validate([
            'title'          => 'nullable|string|max:255',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link'           => 'nullable|string|max:255',
            'order_position' => 'nullable|integer',
            'is_active'      => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $data['image'] = $this->uploadAndCompressImage($request->file('image'), 'banners');
        }

        $banner->update($data);
        $this->logActivity('UPDATE_BANNER', "Memperbarui banner: " . ($banner->title ?? 'Tanpa Judul'));

        return redirect()->route('dashboard.banners')->with('success', 'Banner berhasil diperbarui!');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }

        $title = $banner->title;
        $banner->delete();
        $this->logActivity('DELETE_BANNER', "Menghapus banner: " . ($title ?? 'Tanpa Judul'));

        return back()->with('success', 'Banner berhasil dihapus!');
    }
}
