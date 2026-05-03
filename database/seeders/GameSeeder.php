<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;
use Illuminate\Support\Str;

class GameSeeder extends Seeder
{
    public function run()
    {
        $games = [
            ['name' => 'Mobile Legends: Bang Bang', 'platform' => 'mobile'],
            ['name' => 'Free Fire', 'platform' => 'mobile'],
            ['name' => 'PUBG Mobile', 'platform' => 'mobile'],
            ['name' => 'Genshin Impact', 'platform' => 'mobile'],
            ['name' => 'Valorant', 'platform' => 'pc'],
            ['name' => 'League of Legends', 'platform' => 'pc'],
            ['name' => 'Steam Wallet Code', 'platform' => 'pc'],
            ['name' => 'Call of Duty: Mobile', 'platform' => 'mobile'],
            ['name' => 'E-Football 2024', 'platform' => 'console'],
            ['name' => 'Roblox', 'platform' => 'pc'],
            ['name' => 'Minecraft', 'platform' => 'pc'],
            ['name' => 'Honor of Kings', 'platform' => 'mobile'],
            ['name' => 'Apex Legends', 'platform' => 'pc'],
            ['name' => 'Overwatch 2', 'platform' => 'pc'],
            ['name' => 'PlayStation Network (PSN)', 'platform' => 'console'],
            ['name' => 'Xbox Gift Card', 'platform' => 'console'],
            ['name' => 'Nintendo eShop Card', 'platform' => 'console'],
            ['name' => 'Clash of Clans', 'platform' => 'mobile'],
            ['name' => 'Hay Day', 'platform' => 'mobile'],
            ['name' => 'Clash Royale', 'platform' => 'mobile'],
        ];

        foreach ($games as $g) {
            Game::create([
                'category_id' => 1,
                'input_group_id' => 1,
                'name' => $g['name'],
                'slug' => Str::slug($g['name']) . '-' . Str::random(5),
                'image' => 'games/default.png',
                'banner_image' => 'games/banners/default.png',
                'platform_type' => $g['platform'],
                'description' => 'Top-up ' . $g['name'] . ' murah dan cepat di Ventuz Store. Proses instan 24 jam.',
                'is_active' => true,
            ]);
        }
    }
}
