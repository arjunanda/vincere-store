<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        Article::updateOrCreate(
            ['slug' => Str::slug('Promo Cashback 50% untuk Top-up MLBB!')],
            [
                'title' => 'Promo Cashback 50% untuk Top-up MLBB!',
                'type' => 'promo',
                'image' => 'https://placehold.co/800x450/161616/white?text=PROMO+CASHBACK',
                'excerpt' => 'Dapatkan cashback hingga 50% setiap melakukan top-up Diamond Mobile Legends menggunakan QRIS.',
                'content' => '<p>Nikmati promo terbatas dari Ventuz Store untuk seluruh player Mobile Legends...</p>',
                'published_at' => now(),
            ]
        );

        Article::updateOrCreate(
            ['slug' => Str::slug('Update Patch Valorant: Map Baru Telah Hadir')],
            [
                'title' => 'Update Patch Valorant: Map Baru Telah Hadir',
                'type' => 'berita',
                'image' => 'https://placehold.co/800x450/161616/white?text=VALORANT+NEWS',
                'excerpt' => 'Simak rangkuman lengkap update patch terbaru Valorant yang menghadirkan map baru.',
                'content' => '<p>Riot Games baru saja merilis update besar untuk Valorant...</p>',
                'published_at' => now(),
            ]
        );
    }
}
