<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\{DashboardController, 
                            CheckInController, 
                            HabitController, 
                            ExploreController,
                            BadgeController, 
                            LeaderboardController, 
                            FriendController, 
                            ChatController, 
                            SettingsController, 
                            RecapController,
                            GraveController,
                            AdminController
                         };
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route(auth()->check() ? 'dashboard' : 'register');
});

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/explore', function () {
    return view('explore', [
        'categories' => App\Models\Category::withCount('habits')->orderBy('name')->get(),
    ]);
})->middleware(['auth', 'verified'])->name('explore');

Route::get('/explore/{category}', [ExploreController::class, 'show'])
    ->middleware(['auth', 'verified'])->name('explore.show');

Route::post('/explore/adopt', [ExploreController::class, 'adopt'])
    ->middleware(['auth', 'verified'])->name('explore.adopt');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/check-in', [CheckInController::class, 'store'])->name('checkin.store');
    Route::post('/recover', [CheckInController::class, 'recover'])->name('checkin.recover');
    
    Route::post('/habits', [HabitController::class, 'store'])->name('habits.store');
    Route::patch('/habits/{habit}/toggle', [HabitController::class, 'toggle'])->name('habits.toggle');
    Route::delete('/habits/{habit}', [HabitController::class, 'destroy'])->name('habits.destroy');
    
    Route::get('/badges', [BadgeController::class, 'index'])->name('badges.index');
    Route::post('/badges/{badge}/wear', [BadgeController::class, 'wear'])->name('badges.wear');
    Route::post('/badges/remove', [BadgeController::class, 'remove'])->name('badges.remove');

    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');

    Route::get('/share', function () {
      $user = auth()->user()->load('pet', 'title');

      return view('share', ['user' => $user]);
    })->middleware(['auth', 'verified'])->name('share');

    Route::get('/social', [FriendController::class, 'index'])->name('social.index');
    Route::get('/social/search', [FriendController::class, 'search'])->name('social.search');
    Route::post('/social', [FriendController::class, 'store'])->name('social.store');
    Route::post('/social/{friendship}/accept', [FriendController::class, 'accept'])->name('social.accept');
    Route::post('/social/{friendship}/reject', [FriendController::class, 'reject'])->name('social.reject');

    Route::get('/chat/{friendship}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{friendship}', [ChatController::class, 'store'])->name('chat.store');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');

    Route::get('/recap', [RecapController::class, 'show'])->name('recap.show');

    Route::get('/graves', [GraveController::class, 'index'])->name('graves.index');

    Route::middleware('can:admin')->prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::post('/avatars', [AdminController::class, 'storeAvatar'])->name('admin.avatars.store');
        Route::delete('/avatars/{filename}', [AdminController::class, 'destroyAvatar'])->name('admin.avatars.destroy');
    });
});

require __DIR__.'/auth.php';
