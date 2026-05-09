<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [

            // ── 1 ─────────────────────────────────────────────────────────
            [
                'title'        => 'Cara Top Up Diamond Mobile Legends Paling Murah dan Aman 2024',
                'type'         => 'berita',
                'image'        => 'articles/default.jpg',
                'excerpt'      => 'Temukan cara top up Diamond Mobile Legends (MLBB) dengan harga termurah, proses instan, dan 100% aman. Panduan lengkap untuk pemain Indonesia.',
                'published_at' => now()->subDays(1),
                'content'      => <<<HTML
<h2>Top Up Diamond Mobile Legends Murah di Vincere Store</h2>
<p>Mobile Legends: Bang Bang (MLBB) adalah salah satu game mobile paling populer di Indonesia dengan jutaan pemain aktif setiap harinya. Untuk bisa menikmati hero baru, skin eksklusif, dan berbagai item in-game, kamu membutuhkan Diamond — mata uang utama di game ini.</p>

<h3>Mengapa Harga Diamond MLBB di Vincere Store Lebih Murah?</h3>
<p>Vincere Store bekerja sama langsung dengan distributor resmi Moonton sehingga kami dapat menawarkan harga <strong>Diamond MLBB termurah</strong> di Indonesia. Tidak ada biaya tambahan tersembunyi — harga yang tertera adalah harga akhir yang kamu bayar.</p>

<h3>Cara Top Up Diamond MLBB di Vincere Store</h3>
<ol>
  <li>Buka halaman game <strong>Mobile Legends</strong> di Vincere Store.</li>
  <li>Masukkan <strong>User ID</strong> dan <strong>Zone ID</strong> akun MLBB kamu.</li>
  <li>Pilih jumlah Diamond yang ingin dibeli.</li>
  <li>Pilih metode pembayaran (QRIS, transfer bank, e-wallet).</li>
  <li>Selesaikan pembayaran — Diamond akan masuk dalam hitungan detik.</li>
</ol>

<h3>Tips Hemat Beli Diamond MLBB</h3>
<ul>
  <li><strong>Manfaatkan Weekly Diamond Pass</strong> untuk mendapatkan Diamond harian selama 30 hari.</li>
  <li><strong>Beli saat promo</strong> — Vincere Store rutin mengadakan event cashback dan bonus Diamond.</li>
  <li><strong>Top up nominal besar</strong> biasanya memberikan bonus Diamond ekstra dari Moonton.</li>
</ul>

<h3>Keamanan Transaksi Terjamin</h3>
<p>Semua transaksi di Vincere Store diproses melalui gateway pembayaran berlisensi Bank Indonesia. Data kamu terenkripsi dan tidak pernah disimpan secara permanen. Kami telah melayani ratusan ribu transaksi dengan tingkat keberhasilan 99,9%.</p>

<p>Jangan ragu untuk menghubungi tim CS kami 24 jam via WhatsApp jika ada kendala. Top up Diamond MLBB sekarang dan dominasi ranked game kamu!</p>
HTML,
            ],

            // ── 2 ─────────────────────────────────────────────────────────
            [
                'title'        => 'Harga Diamond Free Fire Terbaru Mei 2024: Beli di Mana Paling Untung?',
                'type'         => 'berita',
                'image'        => 'articles/default.jpg',
                'excerpt'      => 'Cek daftar harga Diamond Free Fire terbaru Mei 2024. Bandingkan harga antar platform dan temukan tempat top up FF paling murah dan terpercaya.',
                'published_at' => now()->subDays(3),
                'content'      => <<<HTML
<h2>Update Harga Diamond Free Fire (FF) Mei 2024</h2>
<p>Free Fire (FF) dari Garena tetap menjadi raja game battle royale mobile di Indonesia. Diamond adalah mata uang premium FF yang dibutuhkan untuk membeli kostum, senjata skin, pet, dan item eksklusif lainnya.</p>

<h3>Tabel Harga Diamond Free Fire Resmi</h3>
<p>Berikut perbandingan harga Diamond FF di berbagai platform:</p>
<ul>
  <li><strong>100 Diamond</strong> — Rp 15.000 (in-game store)</li>
  <li><strong>310 Diamond</strong> — Rp 50.000</li>
  <li><strong>520 Diamond</strong> — Rp 75.000</li>
  <li><strong>1.060 Diamond</strong> — Rp 150.000</li>
  <li><strong>2.180 Diamond</strong> — Rp 300.000</li>
  <li><strong>5.600 Diamond</strong> — Rp 750.000</li>
</ul>

<h3>Kenapa Beli Diamond FF di Vincere Store Lebih Hemat?</h3>
<p>Di Vincere Store, kami menawarkan harga Diamond FF yang kompetitif karena volume transaksi tinggi memungkinkan kami mendapat margin lebih kecil. Selain itu, kami sering mengadakan promo <strong>bonus Diamond</strong> dan <strong>cashback</strong> eksklusif untuk pengguna setia.</p>

<h3>Cara Cek User ID Free Fire Kamu</h3>
<ol>
  <li>Buka game Free Fire.</li>
  <li>Klik ikon profil di pojok kiri atas.</li>
  <li>User ID kamu akan terlihat di bawah nama karakter (9-10 digit angka).</li>
</ol>

<h3>Metode Pembayaran yang Tersedia</h3>
<p>Vincere Store mendukung berbagai metode pembayaran populer di Indonesia:</p>
<ul>
  <li>QRIS (semua e-wallet & mobile banking)</li>
  <li>Transfer Bank (BCA, Mandiri, BNI, BRI)</li>
  <li>GoPay, OVO, Dana, ShopeePay</li>
  <li>Alfamart & Indomaret</li>
</ul>

<p>Top up Diamond FF sekarang di Vincere Store dan raih tier Heroic lebih cepat dengan skin terbaik!</p>
HTML,
            ],

            // ── 3 ─────────────────────────────────────────────────────────
            [
                'title'        => 'Valorant Points (VP) Indonesia: Harga, Cara Beli, dan Tips Hemat 2024',
                'type'         => 'berita',
                'image'        => 'articles/default.jpg',
                'excerpt'      => 'Panduan lengkap membeli Valorant Points (VP) di Indonesia 2024. Ketahui harga terbaru, cara top up, dan tips mendapatkan skin Valorant termurah.',
                'published_at' => now()->subDays(5),
                'content'      => <<<HTML
<h2>Panduan Lengkap Valorant Points (VP) untuk Pemain Indonesia</h2>
<p>Valorant Points (VP) adalah mata uang premium di game taktis FPS Valorant dari Riot Games. Dengan VP, kamu bisa membeli skin senjata, bundle agent, gun buddy, card, dan berbagai kosmetik eksklusif di toko Valorant.</p>

<h3>Harga Valorant Points Resmi di Indonesia (2024)</h3>
<ul>
  <li><strong>475 VP</strong> — Rp 35.000</li>
  <li><strong>1.000 VP</strong> — Rp 70.000</li>
  <li><strong>2.050 VP</strong> — Rp 140.000</li>
  <li><strong>3.650 VP</strong> — Rp 245.000</li>
  <li><strong>5.350 VP</strong> — Rp 350.000</li>
  <li><strong>11.000 VP</strong> — Rp 700.000</li>
</ul>

<h3>Cara Top Up VP Valorant via Vincere Store</h3>
<ol>
  <li>Pilih game <strong>Valorant</strong> di Vincere Store.</li>
  <li>Masukkan <strong>Riot ID</strong> kamu (format: NamaKamu#TAG).</li>
  <li>Pilih jumlah VP yang diinginkan.</li>
  <li>Pilih metode pembayaran dan selesaikan transaksi.</li>
  <li>VP akan dikreditkan langsung ke akun Riot kamu.</li>
</ol>

<h3>Skin Valorant Populer yang Wajib Dimiliki</h3>
<p>Beberapa skin Valorant paling populer yang bisa dibeli dengan VP:</p>
<ul>
  <li><strong>Prime 2.0 Collection</strong> — favorit sepanjang masa</li>
  <li><strong>Glitchpop Collection</strong> — futuristik dan eye-catching</li>
  <li><strong>Elderflame Dragon</strong> — skin paling ikonik</li>
  <li><strong>Champions 2023 Bundle</strong> — edisi terbatas turnamen</li>
</ul>

<h3>Tips Hemat VP Valorant</h3>
<ul>
  <li>Beli VP dalam <strong>nominal besar</strong> untuk mendapatkan bonus VP ekstra.</li>
  <li>Gunakan <strong>Radianite Points</strong> untuk upgrade level skin.</li>
  <li>Pantau <strong>Night Market</strong> yang muncul setiap season untuk diskon skin hingga 50%.</li>
</ul>

<p>Tingkatkan pengalaman bermain Valorant kamu dengan skin premium. Beli VP sekarang di Vincere Store dengan proses instan!</p>
HTML,
            ],

            // ── 4 ─────────────────────────────────────────────────────────
            [
                'title'        => 'Top Up PUBG Mobile UC Murah: Panduan Lengkap untuk Pemain Indonesia',
                'type'         => 'berita',
                'image'        => 'articles/default.jpg',
                'excerpt'      => 'Cara top up Unknown Cash (UC) PUBG Mobile dengan harga murah dan aman di Indonesia. Dapatkan Royal Pass, skin senjata, dan item eksklusif lebih hemat.',
                'published_at' => now()->subDays(7),
                'content'      => <<<HTML
<h2>Unknown Cash (UC) PUBG Mobile: Semua yang Perlu Kamu Tahu</h2>
<p>PUBG Mobile adalah game battle royale legendaris yang masih memiliki basis pemain besar di Indonesia. Unknown Cash (UC) adalah mata uang premium yang digunakan untuk membeli Royal Pass, crate senjata, skin karakter, dan berbagai item eksklusif lainnya.</p>

<h3>Fungsi UC di PUBG Mobile</h3>
<ul>
  <li><strong>Royal Pass (RP)</strong> — Season pass yang memberi ratusan item eksklusif</li>
  <li><strong>Crate Opening</strong> — Buka crate senjata dan karakter langka</li>
  <li><strong>Classic Crate</strong> — Mendapatkan item permanen</li>
  <li><strong>Rename Card & Frame</strong> — Personalisasi profil kamu</li>
</ul>

<h3>Harga UC PUBG Mobile Terbaru</h3>
<ul>
  <li><strong>60 UC</strong> — Rp 14.000</li>
  <li><strong>325 UC</strong> — Rp 65.000</li>
  <li><strong>660 UC</strong> — Rp 129.000</li>
  <li><strong>1.800 UC</strong> — Rp 329.000</li>
  <li><strong>3.850 UC</strong> — Rp 659.000</li>
  <li><strong>8.100 UC</strong> — Rp 1.299.000</li>
</ul>

<h3>Cara Top Up UC PUBG Mobile di Vincere Store</h3>
<ol>
  <li>Masuk ke halaman PUBG Mobile di Vincere Store.</li>
  <li>Masukkan <strong>Character ID</strong> PUBG Mobile kamu.</li>
  <li>Pilih paket UC yang diinginkan.</li>
  <li>Bayar menggunakan QRIS, transfer bank, atau e-wallet.</li>
  <li>UC langsung masuk ke akun PUBG Mobile kamu dalam 1-5 menit.</li>
</ol>

<h3>Apakah Top Up via Pihak Ketiga Aman?</h3>
<p>Pertanyaan ini sering muncul dari pemain baru. Jawaban singkatnya: <strong>aman, selama menggunakan platform terpercaya seperti Vincere Store</strong>. Kami menggunakan metode top up resmi melalui API Krafton yang tidak memerlukan akses ke akun game kamu. Kamu hanya perlu memberikan Character ID — tidak ada password yang diperlukan.</p>

<p>Dapatkan Royal Pass season ini dan jadilah pemain PUBG Mobile paling stylish di server Indonesia!</p>
HTML,
            ],

            // ── 5 ─────────────────────────────────────────────────────────
            [
                'title'        => 'Genshin Impact: Cara Top Up Genesis Crystal dan Primogem Paling Hemat',
                'type'         => 'berita',
                'image'        => 'articles/default.jpg',
                'excerpt'      => 'Panduan top up Genesis Crystal Genshin Impact untuk mendapatkan Primogem lebih banyak. Hemat hingga 40% dibanding beli langsung di in-game store.',
                'published_at' => now()->subDays(10),
                'content'      => <<<HTML
<h2>Sistem Mata Uang Genshin Impact: Genesis Crystal vs Primogem</h2>
<p>Genshin Impact dari HoYoverse memiliki sistem mata uang yang unik. Ada dua jenis mata uang premium: <strong>Genesis Crystal</strong> (beli dengan uang nyata) dan <strong>Primogem</strong> (bisa didapat gratis maupun dari Crystal). Untuk melakukan gacha (Wishes) pada banner karakter dan senjata baru, kamu membutuhkan Primogem atau Intertwined/Acquaint Fate.</p>

<h3>Konversi Genesis Crystal ke Primogem</h3>
<p>1 Genesis Crystal = 1 Primogem. Namun, top up pertama kali memberikan <strong>bonus Crystal double</strong> yang sangat menguntungkan!</p>

<h3>Harga Genesis Crystal di Vincere Store</h3>
<ul>
  <li><strong>60 Crystal</strong> — Rp 14.000</li>
  <li><strong>330 Crystal</strong> — Rp 69.000</li>
  <li><strong>680 Crystal</strong> — Rp 139.000</li>
  <li><strong>2.240 Crystal</strong> — Rp 429.000</li>
  <li><strong>3.880 Crystal</strong> — Rp 729.000</li>
  <li><strong>8.080 Crystal</strong> — Rp 1.459.000</li>
</ul>

<h3>Tips Gacha Efisien di Genshin Impact</h3>
<ul>
  <li>Selalu tunggu banner <strong>5-star karakter favorit</strong> kamu sebelum top up.</li>
  <li>Manfaatkan sistem <strong>pity 90</strong> untuk karakter dan <strong>80</strong> untuk senjata.</li>
  <li>Beli <strong>Welkin Moon</strong> (subscription harian) untuk mendapat Primogem konsisten setiap hari.</li>
  <li>Selesaikan semua <strong>daily commission</strong> dan <strong>event</strong> untuk Primogem gratis.</li>
</ul>

<h3>Cara Top Up Genshin Impact via Vincere Store</h3>
<ol>
  <li>Buka halaman Genshin Impact di Vincere Store.</li>
  <li>Masukkan <strong>UID</strong> Genshin Impact kamu dan pilih <strong>server</strong> (Asia/America/Europe/TW).</li>
  <li>Pilih paket Genesis Crystal.</li>
  <li>Selesaikan pembayaran.</li>
  <li>Crystal langsung masuk ke Mailbox akun HoYoverse kamu.</li>
</ol>

<p>Siap menarik karakter 5-star terbaru? Top up Genesis Crystal sekarang dan raih karakter impian kamu di Genshin Impact!</p>
HTML,
            ],

            // ── 6 ─────────────────────────────────────────────────────────
            [
                'title'        => '5 Game Mobile Dengan Top Up Terlaris di Indonesia Bulan Ini',
                'type'         => 'berita',
                'image'        => 'articles/default.jpg',
                'excerpt'      => 'Inilah 5 game mobile paling laris untuk top up di Indonesia bulan ini. Data real dari jutaan transaksi pengguna aktif Vincere Store.',
                'published_at' => now()->subDays(14),
                'content'      => <<<HTML
<h2>Ranking Game Mobile Terlaris untuk Top Up di Indonesia</h2>
<p>Berdasarkan data transaksi internal Vincere Store, kami merangkum 5 game mobile dengan volume top up tertinggi di Indonesia. Data ini mencerminkan tren gaming Indonesia dan bisa membantu kamu memahami game apa yang paling banyak dimainkan secara aktif.</p>

<h3>1. Mobile Legends: Bang Bang (MLBB)</h3>
<p>Tidak mengejutkan, MLBB tetap mendominasi chart top up dengan pangsa pasar terbesar. Game MOBA 5v5 dari Moonton ini memiliki basis pemain yang sangat loyal dan terus merilis hero serta skin baru setiap bulan, mendorong pemain untuk terus top up Diamond.</p>
<p><strong>Rata-rata pengeluaran per pemain:</strong> Rp 150.000/bulan</p>

<h3>2. Free Fire (FF)</h3>
<p>Free Fire dari Garena menempati posisi kedua, populer terutama di kalangan pemain yang menggunakan smartphone kelas menengah. FF dikenal dengan event in-game yang sangat aktif dan kolaborasi dengan artis/brand populer.</p>
<p><strong>Rata-rata pengeluaran per pemain:</strong> Rp 120.000/bulan</p>

<h3>3. Genshin Impact</h3>
<p>Genshin Impact memimpin dalam kategori <em>nilai transaksi tertinggi per pengguna</em>. Sistem gacha dengan karakter 5-star menarik mendorong pemain untuk menginvestasikan lebih banyak. Komunitas Genshin Indonesia terkenal sangat aktif dan berdedikasi.</p>
<p><strong>Rata-rata pengeluaran per pemain:</strong> Rp 400.000/bulan</p>

<h3>4. PUBG Mobile</h3>
<p>PUBG Mobile tetap kuat dengan Royal Pass season-based yang menciptakan siklus pembelian yang konsisten. UC digunakan tidak hanya untuk RP tetapi juga untuk membuka crate kolaborasi eksklusif.</p>
<p><strong>Rata-rata pengeluaran per pemain:</strong> Rp 100.000/bulan</p>

<h3>5. Clash of Clans</h3>
<p>Kejutan di posisi kelima: Clash of Clans dari Supercell ternyata masih sangat aktif di Indonesia. Pemain lama yang nostalgik dan pemain baru yang tertarik dengan Town Hall baru terus berdatangan, dan Gems tetap menjadi komoditas yang dicari.</p>
<p><strong>Rata-rata pengeluaran per pemain:</strong> Rp 85.000/bulan</p>

<h3>Kesimpulan</h3>
<p>Industri gaming Indonesia terus bertumbuh pesat. Semua game di atas tersedia di Vincere Store dengan harga terbaik dan proses top up instan. Daftar sekarang dan nikmati kemudahan top up game favorit kamu!</p>
HTML,
            ],

        ];

        foreach ($articles as $data) {
            Article::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'title'        => $data['title'],
                    'type'         => $data['type'],
                    'image'        => $data['image'],
                    'excerpt'      => $data['excerpt'],
                    'content'      => $data['content'],
                    'published_at' => $data['published_at'],
                ]
            );
        }
    }
}
