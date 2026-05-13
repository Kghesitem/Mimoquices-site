<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\PersonalizacaoController;
use App\Http\Controllers\FavoritoController;
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
    Route::get('/categoria/criar', [CategoriaController::class,'create'])->name('categoria.criar');
    Route::get('/personalizacao/criar', [PersonalizacaoController::class,'create'])->name('personalizacao.criar');
    Route::get('tabela-pedidos', [PersonalizacaoController::class, 'tabelaPedidos'])->name('tabelaPedidos');
});

Route::get('/produtos/{titulo}', [ProdutoController::class, 'show'])->name('produto.show');
Route::get('/', [ProdutoController::class, 'welcome'])->name('welcome');

Route::get('/produtos', [ProdutoController::class, 'index'])->name('produto.index');
Route::post('/produtos', [ProdutoController::class, 'store'])->name('produto.store');
Route::post('/categoria', [CategoriaController::class, 'store'])->name('categoria.store');
Route::post('/personalizacao', [PersonalizacaoController::class, 'store'])->name('personalizacao.store');
Route::post('/produtos/{titulo}/personalizar', [ProdutoController::class, 'personalizarProduto'])->name('produto.personalizar');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/favoritos/toggle', [ProdutoController::class, 'toggle'])->name('favorito.toggle');
    Route::get('/favoritos', [ProdutoController::class, 'favoritos'])->name('favoritos');

    Route::get('/produtos/{produto}/editar', [ProdutoController::class, 'edit'])->name('produto.edit');
    Route::put('/produtos/{produto}/update', [ProdutoController::class, 'update'])->name('produto.update');
    Route::post('/produto/{id}/visivel', [ProdutoController::class, 'visivel'])->name('produto.visivel');
    Route::post('/produto/{id}/destaque', [ProdutoController::class, 'destaque'])->name('produto.destaque');
    Route::delete('/produto/{id}', [ProdutoController::class, 'destroy'])->name('produto.destroy');
    
    Route::post('/pedido/{id}/atualizar', [PersonalizacaoController::class, 'atualizar'])->name('pedido.atualizar');
    Route::delete('/pedido/{id}/admin', [PersonalizacaoController::class, 'delete'])->name('pedido.delete');
    Route::delete('/pedido/{id}', [PersonalizacaoController::class, 'destroy'])->name('pedido.destroy');
    Route::get('/pedido/{id}', [PersonalizacaoController::class, 'show'])->name('pedido.show');

    Route::get('/categoria/{id}/editar', [CategoriaController::class, 'edit'])->name('categoria.edit');
    Route::put('/categoria/{id}/update', [CategoriaController::class, 'update'])->name('categoria.update');
    Route::delete('/categoria/{id}', [CategoriaController::class, 'destroy'])->name('categoria.destroy');

    Route::delete('/personalizacao/apagar', [PersonalizacaoController::class, 'destroyPersonalizacao'])->name('personalizacao.destroy');
    Route::get('/grafico-favoritos', [FavoritoController::class, 'grafico'])->name('grafico.favoritos');

    Route::get('/historico-personalizacoes', [PersonalizacaoController::class, 'index'])->name('historico');
});

require __DIR__.'/auth.php';
