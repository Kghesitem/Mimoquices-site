<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProdutoController;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sobre', function () {
    return view('sobre');
})->name('sobre');

Route::get('/dashboard', [UserController::class, 'Dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', AdminMiddleware::class])->group(function () {
Route::get('/produtos/criar', [ProdutoController::class,'create'])->name('produto.criar');
});

Route::get('/produtos/{url_completo}', [ProdutoController::class, 'show'])->name('produto.show');
Route::get('/', [ProdutoController::class, 'welcome'])->name('welcome');

Route::get('/produtos', [ProdutoController::class, 'index'])->name('produto.index');
Route::post('/produtos', [ProdutoController::class, 'store'])->name('produto.store');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
