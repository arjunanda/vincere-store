<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $games = \App\Models\Game::where('is_active', true)
            ->with('category')
            ->withCount([
                'transactions' => function ($query) {
                    $query->whereIn('payment_status', ['success', 'verif', 'completed']);
                }
            ])
            ->orderBy('transactions_count', 'desc')
            ->get();

        $banners = \App\Models\Banner::where('is_active', true)->orderBy('order_position', 'asc')->get();
        $articles = \App\Models\Article::where('is_active', true)->orderBy('created_at', 'desc')->take(4)->get();

        return view('frontend.index', compact('games', 'banners', 'articles'));
    }

    public function games()
    {
        $games = \App\Models\Game::with('category')->where('is_active', true)->get();
        $categories = \App\Models\Category::orderBy('name')->get();
        return view('frontend.games', compact('games', 'categories'));
    }

    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }
        return view('auth.register');
    }

    public function registerPost(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'whatsapp' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'whatsapp' => $data['whatsapp'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('dashboard.index')->with('success', 'Pendaftaran berhasil! Selamat datang di Ventuz Store.');
    }

    public function checkTransaction(Request $request)
    {
        $transaction = null;
        if ($request->filled('order_id')) {
            $transaction = \App\Models\Transaction::where('order_id', $request->order_id)->first();
        }
        return view('frontend.check-transaction', compact('transaction'));
    }

    public function news()
    {
        $articles = \App\Models\Article::where('is_active', true)->orderBy('created_at', 'desc')->get();
        return view('frontend.news', compact('articles'));
    }

    public function newsDetail($slug)
    {
        $article = \App\Models\Article::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $relatedArticles = \App\Models\Article::where('id', '!=', $article->id)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('frontend.news_detail', compact('article', 'relatedArticles'));
    }

    public function gameDetail($slug)
    {
        $game = \App\Models\Game::where('slug', $slug)
            ->with([
                'variants' => function ($q) {
                    $q->where('is_active', true)->orderBy('price');
                },
                'inputGroup.fields'
            ])
            ->firstOrFail();

        $paymentMethods = \App\Models\PaymentMethod::where('is_active', true)
            ->orderBy('id', 'asc')
            ->get();

        return view('frontend.game-detail', compact('game', 'paymentMethods'));
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'game_id' => 'required|exists:games,id',
            'variant_id' => 'required|exists:game_variants,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'whatsapp' => 'nullable|string',
        ]);

        $game = \App\Models\Game::findOrFail($validated['game_id']);
        $variant = \App\Models\GameVariant::findOrFail($validated['variant_id']);
        $paymentMethod = \App\Models\PaymentMethod::findOrFail($validated['payment_method_id']);

        // Collect dynamic input fields
        $inputFields = [];
        if ($game->inputGroup) {
            foreach ($game->inputGroup->fields as $field) {
                $inputFields[$field->label] = $request->input($field->name);
            }
        }

        // Priority: Auth User WhatsApp > Input WhatsApp
        $whatsapp = $request->input('whatsapp');
        if (auth()->check() && auth()->user()->whatsapp) {
            $whatsapp = auth()->user()->whatsapp;
        }

        if ($whatsapp) {
            $inputFields['WhatsApp'] = $whatsapp;
        }

        // Create transaction
        $transaction = \App\Models\Transaction::create([
            'order_id' => 'VTZ-' . strtoupper(\Illuminate\Support\Str::random(10)),
            'user_id' => auth()->id(),
            'game_id' => $game->id,
            'game_name' => $game->name,
            'variant_id' => $variant->id,
            'variant_name' => $variant->name,
            'input_data' => $inputFields,
            'total_price' => $variant->price + $paymentMethod->fee,
            'payment_method' => $paymentMethod->name,
            'payment_status' => 'pending',
            'delivery_status' => 'pending',
        ]);


        return redirect()->route('checkout.success', ['order_id' => $transaction->order_id]);
    }

    public function checkoutSuccess($order_id)
    {

        $transaction = \App\Models\Transaction::where('order_id', $order_id)->firstOrFail();
        $game = \App\Models\Game::findOrFail($transaction->game_id);
        $variant = \App\Models\GameVariant::findOrFail($transaction->variant_id);
        $paymentMethod = \App\Models\PaymentMethod::where('name', $transaction->payment_method)->first();

        return view('frontend.checkout', compact('transaction', 'game', 'variant', 'paymentMethod'));
    }

    public function streamStatus($order_id)
    {
        $transaction = \App\Models\Transaction::where('order_id', $order_id)->first();
        if (!$transaction) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json([
            'payment_status' => $transaction->payment_status,
            'delivery_status' => $transaction->delivery_status,
        ]);
    }

    public function __construct(protected \App\Services\WhatsAppService $waService)
    {
    }

    public function uploadProof(Request $request, $order_id)
    {
        $request->validate([
            'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $transaction = \App\Models\Transaction::where('order_id', $order_id)->firstOrFail();

        // Optimize and Convert to WebP
        $file = $request->file('proof_of_payment');
        $filename = \Illuminate\Support\Str::random(20) . '.webp';
        $path = 'proofs/' . $filename;

        // Use Intervention Image to process
        \Intervention\Image\Laravel\Facades\Image::decode($file)
            ->encodeUsingFileExtension('webp', quality: 80)
            ->save(storage_path('app/public/' . $path));

        $oldStatus = $transaction->payment_status;

        $transaction->update([
            'proof_of_payment' => $path,
            'payment_status' => 'verif',
        ]);

        // Send WhatsApp Notification to CS (Only if it's the first upload/still pending)
        try {
            $csPhoneRaw = \App\Models\Setting::where('key', 'contact_wa')->value('value');


            if ($csPhoneRaw && $oldStatus === 'pending') {
                // Reformat CS Phone: remove non-digits and ensure 62 prefix
                $csPhone = preg_replace('/[^0-9]/', '', $csPhoneRaw);
                if (str_starts_with($csPhone, '0')) {
                    $csPhone = '62' . substr($csPhone, 1);
                }

                \Illuminate\Support\Facades\Log::info("Attempting to send WA notification to CS", [
                    'order_id' => $transaction->order_id,
                    'target_phone' => $csPhone
                ]);

                $inputFields = "";
                foreach ($transaction->input_data as $label => $value) {
                    if ($label !== 'WhatsApp') {
                        $inputFields .= "- *{$label}:* {$value}\n";
                    }
                }

                $caption = "🚨 *KONFIRMASI PEMBAYARAN BARU* 🚨\n\n";
                $caption .= "*Detail Transaksi:*\n";
                $caption .= "- *ID:* #{$transaction->order_id}\n";
                $caption .= "- *Game:* {$transaction->game_name}\n";
                $caption .= "- *Produk:* {$transaction->variant_name}\n";
                $caption .= "- *Total:* Rp " . number_format($transaction->total_price) . "\n";
                $caption .= "- *Metode:* {$transaction->payment_method}\n\n";
                $caption .= "*Data User:*\n{$inputFields}";

                $waPembeli = $transaction->input_data['WhatsApp'] ?? '-';
                if ($waPembeli !== '-') {
                    $cleanWA = preg_replace('/[^0-9]/', '', $waPembeli);
                    if (str_starts_with($cleanWA, '0'))
                        $cleanWA = '62' . substr($cleanWA, 1);
                    $caption .= "*WA Pembeli:* wa.me/{$cleanWA}\n";
                }

                $caption .= "\n*Link Verifikasi Dashboard:*\n" . url('/dashboard/orders?search=' . $transaction->order_id);

                // Send Image (Payment Proof) to CS
                $response = $this->waService->sendMessage(
                    $csPhone,
                    $caption
                );

                \Illuminate\Support\Facades\Log::info("WA notification response", [
                    'order_id' => $transaction->order_id,
                    'response' => $response
                ]);
            } else {
                \Illuminate\Support\Facades\Log::warning("WA notification skipped", [
                    'order_id' => $transaction->order_id,
                    'has_cs_phone' => !empty($csPhoneRaw),
                    'status' => $oldStatus
                ]);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to send WA notification to CS", [
                'order_id' => $transaction->order_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }

        return redirect()->route('checkout.success', ['order_id' => $order_id])
            ->with('success', 'Bukti pembayaran berhasil diunggah! Pesanan Anda segera diproses.');
    }
}
