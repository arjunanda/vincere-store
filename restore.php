<?php
$changes = [
    ["file" => "resources/views/components/logo.blade.php", "search" => "<span class=\"{{ \$current['ventuz'] }} font-black italic tracking-tighter text-white uppercase pr-2\">Vincere</span>", "replace" => "<span class=\"{{ \$current['ventuz'] }} font-black italic tracking-tighter metallic-text uppercase pr-2\">Vincere</span>"],
    ["file" => "resources/views/auth/login.blade.php", "search" => "<h1 class=\"text-3xl md:text-4xl font-black tracking-tighter text-white uppercase italic mb-2\">Selamat Datang</h1>", "replace" => "<h1 class=\"text-3xl md:text-4xl font-black tracking-tighter metallic-text uppercase italic mb-2\">Selamat Datang</h1>"],
    ["file" => "resources/views/dashboard/games/create.blade.php", "search" => "<h1 class=\"text-2xl font-black italic uppercase tracking-tight text-white\">Tambah <span class=\"text-brand-red\">Game Baru</span></h1>", "replace" => "<h1 class=\"text-2xl font-black italic uppercase tracking-tight metallic-text\">Tambah <span class=\"text-brand-red\">Game Baru</span></h1>"],
    ["file" => "resources/views/dashboard/games/edit.blade.php", "search" => "<h1 class=\"text-2xl font-black italic uppercase tracking-tight text-white\">Edit <span class=\"text-brand-red\">Game</span></h1>", "replace" => "<h1 class=\"text-2xl font-black italic uppercase tracking-tight metallic-text\">Edit <span class=\"text-brand-red\">Game</span></h1>"],
    ["file" => "resources/views/dashboard/games/items.blade.php", "search" => "<span class=\"text-white\">Set Item:</span> <span class=\"text-brand-red\">{{ \$game->name }}</span>", "replace" => "<span class=\"metallic-text\">Set Item:</span> <span class=\"text-brand-red\">{{ \$game->name }}</span>"],
    ["file" => "resources/views/dashboard/games/items.blade.php", "search" => "<h3 class=\"text-xl font-black italic uppercase text-white\">Tambah <span class=\"text-brand-red\">Item</span></h3>", "replace" => "<h3 class=\"text-xl font-black italic uppercase metallic-text\">Tambah <span class=\"text-brand-red\">Item</span></h3>"],
    ["file" => "resources/views/dashboard/games/items.blade.php", "search" => "<h3 class=\"text-xl font-black italic uppercase text-white\">Salin <span class=\"text-brand-red\">Item</span></h3>", "replace" => "<h3 class=\"text-xl font-black italic uppercase metallic-text\">Salin <span class=\"text-brand-red\">Item</span></h3>"],
    // Keeping edit_item.blade.php as text-white since the user probably wanted this specific one changed
    ["file" => "resources/views/dashboard/my-orders/index.blade.php", "search" => "<h1 class=\"text-3xl font-black italic uppercase tracking-tight text-white\">Pesanan <span class=\"text-brand-red\">Saya</span></h1>", "replace" => "<h1 class=\"text-3xl font-black italic uppercase tracking-tight metallic-text\">Pesanan <span class=\"text-brand-red\">Saya</span></h1>"],
    ["file" => "resources/views/dashboard/topup/index.blade.php", "search" => "<h1 class=\"text-3xl font-black italic uppercase tracking-tight text-white\">Top-up <span class=\"text-brand-red\">Poin</span></h1>", "replace" => "<h1 class=\"text-3xl font-black italic uppercase tracking-tight metallic-text\">Top-up <span class=\"text-brand-red\">Poin</span></h1>"],
    ["file" => "resources/views/dashboard/topup/index.blade.php", "search" => "<h4 class=\"text-lg font-black uppercase tracking-widest text-white mb-6\">Pilih Nominal</h4>", "replace" => "<h4 class=\"text-lg font-black uppercase tracking-widest metallic-text mb-6\">Pilih Nominal</h4>"],
    ["file" => "resources/views/dashboard/payments/edit.blade.php", "search" => "<h1 class=\"text-2xl font-black italic uppercase tracking-tight text-white\">Edit <span class=\"text-brand-red\">Metode</span></h1>", "replace" => "<h1 class=\"text-2xl font-black italic uppercase tracking-tight metallic-text\">Edit <span class=\"text-brand-red\">Metode</span></h1>"],
    ["file" => "resources/views/dashboard/payments/create.blade.php", "search" => "<h1 class=\"text-2xl font-black italic uppercase tracking-tight text-white\">Tambah <span class=\"text-brand-red\">Metode</span></h1>", "replace" => "<h1 class=\"text-2xl font-black italic uppercase tracking-tight metallic-text\">Tambah <span class=\"text-brand-red\">Metode</span></h1>"],
    ["file" => "resources/views/auth/register.blade.php", "search" => "<h1 class=\"text-3xl md:text-4xl font-black tracking-tighter text-white uppercase italic mb-2\">Gabung Elit</h1>", "replace" => "<h1 class=\"text-3xl md:text-4xl font-black tracking-tighter metallic-text uppercase italic mb-2\">Gabung Elit</h1>"],
    ["file" => "resources/views/frontend/news.blade.php", "search" => "<h1 class=\"text-4xl md:text-7xl font-black tracking-tighter italic text-white uppercase leading-none\">", "replace" => "<h1 class=\"text-4xl md:text-7xl font-black tracking-tighter italic metallic-text uppercase leading-none\">"],
    ["file" => "resources/views/frontend/games.blade.php", "search" => "<h1 class=\"text-4xl md:text-7xl font-black tracking-tighter italic text-white uppercase leading-none\">", "replace" => "<h1 class=\"text-4xl md:text-7xl font-black tracking-tighter italic metallic-text uppercase leading-none\">"],
    ["file" => "resources/views/frontend/check-transaction.blade.php", "search" => "<h1 class=\"text-4xl md:text-6xl font-black tracking-tighter italic text-white uppercase leading-none\">", "replace" => "<h1 class=\"text-4xl md:text-6xl font-black tracking-tighter italic metallic-text uppercase leading-none\">"],
    ["file" => "resources/views/frontend/checkout.blade.php", "search" => "<h1 class=\"text-4xl md:text-6xl font-black italic uppercase tracking-tighter text-white\">Pesanan <span class=\"text-brand-red text-shadow-glow\">Berhasil!</span></h1>", "replace" => "<h1 class=\"text-4xl md:text-6xl font-black italic uppercase tracking-tighter metallic-text\">Pesanan <span class=\"text-brand-red text-shadow-glow\">Berhasil!</span></h1>"],
];

foreach ($changes as $c) {
    if (file_exists($c['file'])) {
        $content = file_get_contents($c['file']);
        $newContent = str_replace($c['search'], $c['replace'], $content);
        if ($newContent !== $content) {
            file_put_contents($c['file'], $newContent);
            echo "Restored HTML in " . $c['file'] . "\n";
        }
    }
}

$cssToAdd = "
        .metallic-text {
            background: linear-gradient(135deg, #ffffff 0%, #a1a1aa 25%, #4b5563 50%, #a1a1aa 75%, #ffffff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: 200% auto;
            animation: shine 8s linear infinite;
        }
        @keyframes shine { to { background-position: 200% center; } }
        .group:hover .metallic-text {
            animation: shine 4s linear infinite;
        }
";

$cssFiles = [
    "resources/views/frontend/index.blade.php",
    "resources/views/frontend/checkout.blade.php",
    "resources/views/frontend/check-transaction.blade.php",
    "resources/views/frontend/games.blade.php",
    "resources/views/frontend/news.blade.php",
    "resources/views/auth/register.blade.php",
    "resources/views/auth/login.blade.php"
];

foreach ($cssFiles as $f) {
    if (file_exists($f)) {
        $content = file_get_contents($f);
        // Add before </style>
        if (strpos($content, '.metallic-text') === false && strpos($content, '</style>') !== false) {
            $newContent = str_replace("</style>", $cssToAdd . "    </style>", $content);
            file_put_contents($f, $newContent);
            echo "Restored CSS in $f\n";
        }
    }
}
?>
