<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        Banner::updateOrCreate(
            ['title' => 'Top Up Diamond MLBB Murah'],
            [
                'image' => 'https://placehold.co/1200x600/161616/white?text=BANNER+1',
                'link' => '/games/mobile-legends',
                'order_position' => 1
            ]
        );

        Banner::updateOrCreate(
            ['title' => 'Event Valorant Night Market'],
            [
                'image' => 'https://placehold.co/1200x600/161616/white?text=BANNER+2',
                'link' => '/games/valorant',
                'order_position' => 2
            ]
        );
    }
}
