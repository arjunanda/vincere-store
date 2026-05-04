<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Webhook\WhatsAppController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\GameController;
use App\Http\Controllers\Dashboard\GameItemController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\InputController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\PaymentController;
use App\Http\Controllers\Dashboard\BannerController;
use App\Http\Controllers\Dashboard\ArticleController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\ActivityLogController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\WebsiteSettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// WhatsApp Webhook
Route::post('/webhooks/whatsapp', [WhatsAppController::class, 'handle']);

// Frontend Routes
Route::get('/', [LandingController::class, 'index'])->name('index');
Route::get('/games', [LandingController::class, 'games'])->name('games.index');
Route::get('/check-transaction', [LandingController::class, 'checkTransaction'])->name('check.transaction');
Route::get('/news', [LandingController::class, 'news'])->name('news.index');
Route::get('/news/{slug}', [LandingController::class, 'newsDetail'])->name('news.detail');
Route::get('/game/{slug}', [LandingController::class, 'gameDetail'])->name('game.detail');
Route::post('/checkout', [LandingController::class, 'checkout'])->name('checkout');
Route::get('/checkout/{order_id}', [LandingController::class, 'checkoutSuccess'])->name('checkout.success');
Route::get('/checkout/{order_id}/status', [LandingController::class, 'streamStatus'])->name('checkout.status');
Route::post('/checkout/{order_id}/proof', [LandingController::class, 'uploadProof'])->name('checkout.proof');

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [LandingController::class, 'register'])->name('register');
Route::post('/register', [LandingController::class, 'registerPost'])->name('register.post');

// Dashboard Routes (Protected)
Route::middleware(['auth'])->group(function () {
    Route::prefix('dashboard')->name('dashboard.')->group(function () {

        // Overview
        Route::get('/', [DashboardController::class, 'index'])->name('index');

        // Admin Routes
        Route::middleware([\App\Http\Middleware\IsAdmin::class])->group(function () {

            // Games
            Route::get('/games', [GameController::class, 'index'])->name('games');
            Route::get('/games/create', [GameController::class, 'create'])->name('games.create');
            Route::post('/games', [GameController::class, 'store'])->name('games.store');
            Route::get('/games/{game}/edit', [GameController::class, 'edit'])->name('games.edit');
            Route::put('/games/{game}', [GameController::class, 'update'])->name('games.update');
            Route::patch('/games/{game}/toggle-status', [GameController::class, 'toggleStatus'])->name('games.toggle-status');
            Route::delete('/games/{game}', [GameController::class, 'destroy'])->name('games.destroy');

            // Game Items
            Route::get('/games/{game}/items', [GameItemController::class, 'index'])->name('games.items');
            Route::post('/games/{game}/items', [GameItemController::class, 'store'])->name('games.items.store');
            Route::post('/games/{game}/items/import', [GameItemController::class, 'import'])->name('games.items.import');
            Route::get('/items/{variant}/edit', [GameItemController::class, 'edit'])->name('items.edit');
            Route::put('/items/{variant}', [GameItemController::class, 'update'])->name('items.update');
            Route::delete('/items/{variant}', [GameItemController::class, 'destroy'])->name('items.destroy');

            // Categories
            Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
            Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
            Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
            Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

            // Master Input
            Route::get('/inputs', [InputController::class, 'index'])->name('inputs');
            Route::post('/inputs', [InputController::class, 'storeGroup'])->name('inputs.store');
            Route::get('/inputs/{group}', [InputController::class, 'editGroup'])->name('inputs.edit');
            Route::put('/inputs/{group}', [InputController::class, 'updateGroup'])->name('inputs.update');
            Route::post('/inputs/{group}/fields', [InputController::class, 'storeField'])->name('inputs.fields.store');
            Route::put('/inputs/fields/{field}', [InputController::class, 'updateField'])->name('inputs.fields.update');
            Route::delete('/inputs/fields/{field}', [InputController::class, 'destroyField'])->name('inputs.fields.destroy');
            Route::delete('/inputs/{group}', [InputController::class, 'destroyGroup'])->name('inputs.destroy');

            // Orders
            Route::get('/orders', [OrderController::class, 'index'])->name('orders');
            Route::patch('/orders/{transaction}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');

            // Payments
            Route::get('/payments', [PaymentController::class, 'index'])->name('payments');
            Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
            Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
            Route::get('/payments/{payment}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
            Route::put('/payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');
            Route::patch('/payments/{payment}/toggle-status', [PaymentController::class, 'toggleStatus'])->name('payments.toggle-status');
            Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');

            // Banners
            Route::get('/banners', [BannerController::class, 'index'])->name('banners');
            Route::get('/banners/create', [BannerController::class, 'create'])->name('banners.create');
            Route::post('/banners', [BannerController::class, 'store'])->name('banners.store');
            Route::get('/banners/{banner}/edit', [BannerController::class, 'edit'])->name('banners.edit');
            Route::put('/banners/{banner}', [BannerController::class, 'update'])->name('banners.update');
            Route::delete('/banners/{banner}', [BannerController::class, 'destroy'])->name('banners.destroy');

            // Articles
            Route::get('/articles', [ArticleController::class, 'index'])->name('articles');
            Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
            Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
            Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
            Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
            Route::patch('/articles/{article}/toggle-status', [ArticleController::class, 'toggleStatus'])->name('articles.toggle-status');
            Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');

            // Users
            Route::get('/users', [UserController::class, 'index'])->name('users');
            Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/users', [UserController::class, 'store'])->name('users.store');
            Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
            Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

            // Activity Logs
            Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs');

            // Website Settings
            Route::get('/settings', [WebsiteSettingController::class, 'index'])->name('settings');
            Route::put('/settings', [WebsiteSettingController::class, 'update'])->name('settings.update');
        });

        // Profile & Security (Accessible by all authenticated users)
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/security', [ProfileController::class, 'security'])->name('security');
        Route::put('/security', [ProfileController::class, 'updatePassword'])->name('security.update');

        // User Routes
        Route::get('/my-orders', [DashboardController::class, 'myOrders'])->name('my-orders');
        Route::get('/topup', [DashboardController::class, 'topup'])->name('topup');
    });
});
