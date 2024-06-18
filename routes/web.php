<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Route::get('/', function () {
//     Route::redirect('/', '/login');
// });
Route::redirect('/', '/login');

// Route::redirect('/', '/posts');
Route::resource('posts', PostController::class);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::post('/login', [AuthenticatedSessionController::class, 'create'])->name('login');

Route::get('/dashboard', function () {
    return redirect()->route('posts.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

URL::forceScheme('https');

require __DIR__.'/auth.php';
