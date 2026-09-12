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
                            AdminController,
                            LetterController,
                            CommunityController
                         };
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return view('landing');
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

    Route::get('/memories', [GraveController::class, 'memories'])->name('memories.index');
    
    Route::get('/letters', [LetterController::class, 'index'])->name('letters.index');
    Route::get('/letters/{letter}', [LetterController::class, 'show'])->name('letters.show');
    Route::post('/letters', [LetterController::class, 'store'])->name('letters.store');
    
    Route::post('/recover', [CheckInController::class, 'recover'])->name('checkin.recover');
    Route::post('/hard-day', [CheckInController::class, 'hardDay'])->name('checkin.hardday');
    
    Route::get('/community', [CommunityController::class, 'index'])->name('community.index');
    Route::get('/community/post/{post}', [CommunityController::class, 'detail'])->name('community.detail');
    Route::post('/community/{post}/comment', [CommunityController::class, 'comment'])->name('community.comment');
    Route::delete('/community/comment/{comment}', [CommunityController::class, 'destroyComment'])->name('community.comment.destroy');
    Route::post('/community/comment/{comment}/fire', [CommunityController::class, 'fire'])->name('community.fire');
    Route::post('/community/report', [CommunityController::class, 'report'])->name('community.report');
    Route::get('/community/{category}', [CommunityController::class, 'show'])->name('community.show');
    Route::post('/community', [CommunityController::class, 'store'])->name('community.store');
    Route::delete('/community/{post}', [CommunityController::class, 'destroy'])->name('community.destroy');
    Route::post('/community/{post}/vote', [CommunityController::class, 'vote'])->name('community.vote');
});
    
    Route::middleware('can:admin')->prefix('admin')->group(function () {
        Route::redirect('/', '/admin/users');

        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

        Route::get('/posts', [AdminController::class, 'posts'])->name('admin.posts');
        Route::delete('/posts/{post}', [AdminController::class, 'destroyPost'])->name('admin.posts.destroy');
        Route::delete('/comments/{comment}', [AdminController::class, 'destroyComment'])->name('admin.comments.destroy');

        Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
        Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
        
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
        Route::post('/settings', [AdminController::class, 'storeSettings'])->name('admin.settings.store');

        Route::get('/avatars', [AdminController::class, 'avatars'])->name('admin.avatars');
        Route::post('/avatars', [AdminController::class, 'storeAvatar'])->name('admin.avatars.store');
        Route::delete('/avatars/{filename}', [AdminController::class, 'destroyAvatar'])->name('admin.avatars.destroy');
        
        Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
        Route::delete('/reports/{report}/dismiss', [AdminController::class, 'dismissReport'])->name('admin.reports.dismiss');
        Route::delete('/reports/{report}/resolve', [AdminController::class, 'resolveReport'])->name('admin.reports.resolve');
    
});

require __DIR__.'/auth.php';
