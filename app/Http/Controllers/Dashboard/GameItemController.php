<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Traits\DashboardHelpers;
use App\Models\Game;
use App\Models\GameVariant;
use Illuminate\Http\Request;

class GameItemController extends Controller
{
    use DashboardHelpers;

    public function index(Game $game)
    {
        $game->load('variants');
        return view('dashboard.games.items', compact('game'));
    }

    public function store(Request $request, Game $game)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $game->variants()->create($data);
        return back()->with('success', 'Item berhasil ditambahkan!');
    }

    public function edit(GameVariant $variant)
    {
        return view('dashboard.games.edit_item', compact('variant'));
    }

    public function update(Request $request, GameVariant $variant)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $variant->update($data);
        return redirect()->route('dashboard.games.items', $variant->game_id)->with('success', 'Item berhasil diperbarui!');
    }

    public function import(Request $request, Game $game)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls',
        ]);

        $file = $request->file('file');
        
        // Handle CSV
        if ($file->getClientOriginalExtension() === 'csv' || $file->getClientOriginalExtension() === 'txt') {
            if (($handle = fopen($file->getRealPath(), 'r')) !== FALSE) {
                // Skip header if exists
                $header = fgetcsv($handle, 1000, ',');
                
                // Simple detection if first row is header
                if (!is_numeric($header[1] ?? '')) {
                    // It's a header, continue
                } else {
                    // It's data, reset or handle
                    rewind($handle);
                }

                while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                    if (count($data) >= 2) {
                        $game->variants()->create([
                            'name'  => $data[0],
                            'price' => (float) str_replace(['.', ','], ['', '.'], $data[1]),
                        ]);
                    }
                }
                fclose($handle);
            }
        } else {
            return back()->with('error', 'Saat ini hanya mendukung format .csv. Silakan simpan Excel Anda sebagai CSV.');
        }

        return back()->with('success', 'Item berhasil di-import!');
    }

    public function destroy(GameVariant $variant)
    {
        $variant->delete();
        return back()->with('success', 'Item berhasil dihapus!');
    }
}
