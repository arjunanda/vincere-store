<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Game;
use App\Models\InputGroup;
use App\Models\InputField;
use App\Models\GameVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Categories (Service Types)
        $topup = Category::updateOrCreate(
            ['slug' => 'top-up-game'],
            ['name' => 'Top-up Game']
        );
        
        $voucher = Category::updateOrCreate(
            ['slug' => 'voucher-game'],
            ['name' => 'Voucher Game']
        );

        // 2. Input Master Templates
        $mlGroup = InputGroup::updateOrCreate(['name' => 'Format MLBB (ID + Zone)']);
        InputField::updateOrCreate(
            ['input_group_id' => $mlGroup->id, 'name' => 'user_id'],
            ['label' => 'User ID', 'placeholder' => 'Contoh: 12345678', 'type' => 'number']
        );
        InputField::updateOrCreate(
            ['input_group_id' => $mlGroup->id, 'name' => 'zone_id'],
            ['label' => 'Zone ID', 'placeholder' => 'Contoh: 1234', 'type' => 'number']
        );

        $globalGroup = InputGroup::updateOrCreate(['name' => 'Format Global (User ID Only)']);
        InputField::updateOrCreate(
            ['input_group_id' => $globalGroup->id, 'name' => 'user_id'],
            ['label' => 'Player ID / User ID', 'placeholder' => 'Masukkan ID Anda', 'type' => 'text']
        );

        // 3. Games
        $mlbb = Game::updateOrCreate(
            ['slug' => 'mobile-legends'],
            [
                'category_id' => $topup->id,
                'input_group_id' => $mlGroup->id,
                'name' => 'Mobile Legends',
                'image' => 'https://placehold.co/400x400/161616/white?text=MLBB',
                'platform_type' => 'mobile',
                'description' => 'Top up Diamond Mobile Legends termurah dan tercepat.'
            ]
        );

        GameVariant::updateOrCreate(['game_id' => $mlbb->id, 'name' => '86 Diamonds'], ['price' => 20000]);
        GameVariant::updateOrCreate(['game_id' => $mlbb->id, 'name' => '172 Diamonds'], ['price' => 40000]);

        $val = Game::updateOrCreate(
            ['slug' => 'valorant'],
            [
                'category_id' => $topup->id,
                'input_group_id' => $globalGroup->id,
                'name' => 'Valorant',
                'image' => 'https://placehold.co/400x400/161616/white?text=VALORANT',
                'platform_type' => 'pc',
                'description' => 'Isi Valorant Points instan 24 jam.'
            ]
        );

        GameVariant::updateOrCreate(['game_id' => $val->id, 'name' => '625 Points'], ['price' => 65000]);
    }
}
