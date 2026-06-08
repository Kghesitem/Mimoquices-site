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
use App\Http\Controllers\NewsletterController;

// ------------------------------------------------------------------------------
// Rotas públicas
    Route::get('/', function () {return view('welcome');});
    Route::get('/', [ProdutoController::class, 'welcome'])->name('welcome');
// ---------------------------------------------------------------------------------

// Rota para exibir a página "Sobre" (página estática)
Route::get('/sobre', function () {return view('sobre');})->name('sobre');


Route::get('/dashboard', [UserController::class, 'Dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/produto/{titulo}', [ProdutoController::class, 'show'])->name('produto.show');

Route::get('/produtos', [ProdutoController::class, 'index'])->name('produto.index');
Route::post('/produto/{titulo}/personalizar', [ProdutoController::class, 'personalizarProduto'])->name('produto.personalizar');

Route::get('/newsletter/unsubscribe/{user}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe')->middleware('signed');

Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    // Rotas para criar novos produtos, categorias e personalizações
        Route::get('/produtos/criar', [ProdutoController::class,'create'])->name('produto.criar');
        Route::get('/categoria/criar', [CategoriaController::class,'create'])->name('categoria.criar');
        Route::get('/personalizacao/criar', [PersonalizacaoController::class,'create'])->name('personalizacao.criar');
    // ---------------------------------------------------------------------------------

    // Rota para criar um novo produto com o store
        Route::post('/produtos', [ProdutoController::class, 'store'])->name('produto.store');
        Route::post('/categoria', [CategoriaController::class, 'store'])->name('categoria.store');
        Route::post('/personalizacao', [PersonalizacaoController::class, 'store'])->name('personalizacao.store');
    // ---------------------------------------------------------------------------------
});

Route::middleware('auth')->group(function () {

    // Rotas para editar, atualizar e apagar perfil -- (apenas para usuário autenticado)
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // ---------------------------------------------------------------------------------

    // Rota para alternar favoritos e exibir favoritos do cliente (apenas para usuário autenticado)
        Route::post('/favoritos/toggle', [ProdutoController::class, 'toggle'])->name('favorito.toggle');
        Route::get('/favoritos', [ProdutoController::class, 'favoritos'])->name('favoritos');
    // ---------------------------------------------------------------------------------

    // Rotas para editar, colocar visivel, destacar, atualizar e apagar produtos -- (apenas para admin)
        Route::get('/produto/{produto}/editar', [ProdutoController::class, 'edit'])->name('produto.edit');
        Route::put('/produto/{produto}/update', [ProdutoController::class, 'update'])->name('produto.update');
        Route::post('/produto/{id}/visivel', [ProdutoController::class, 'visivel'])->name('produto.visivel');
        Route::post('/produto/{id}/destaque', [ProdutoController::class, 'destaque'])->name('produto.destaque');
        Route::delete('/produto/{id}', [ProdutoController::class, 'destroy'])->name('produto.destroy');
    // ---------------------------------------------------------------------------------

    // Rotas para editar, atualizar e apagar personalizações -- (apenas para admin)
        Route::post('/pedido/{id}/atualizar', [PersonalizacaoController::class, 'atualizar'])->name('pedido.atualizar');
        Route::delete('/pedido/{id}/admin', [PersonalizacaoController::class, 'delete'])->name('pedido.delete');
        Route::delete('/pedido/{id}', [PersonalizacaoController::class, 'destroy'])->name('pedido.destroy');
        Route::get('/pedido/{id}', [PersonalizacaoController::class, 'show'])->name('pedido.show');
    // ---------------------------------------------------------------------------------

    // Rotas para editar, atualizar e apagar categorias -- (apenas para admin)
        Route::get('/categoria/{id}/editar', [CategoriaController::class, 'edit'])->name('categoria.edit');
        Route::put('/categoria/{id}/update', [CategoriaController::class, 'update'])->name('categoria.update');
        Route::delete('/categoria/{id}', [CategoriaController::class, 'destroy'])->name('categoria.destroy');
    // ---------------------------------------------------------------------------------

    // Rota para apagar personalização -- (apenas para admin)
       
        Route::get('/personalizacao/{id}/editar', [PersonalizacaoController::class, 'edit'])->name('personalizacao.edit');
        Route::put('/personalizacao/{id}/update', [PersonalizacaoController::class, 'update'])->name('personalizacao.update');
        Route::delete('/personalizacao/apagar', [PersonalizacaoController::class, 'destroyPersonalizacao'])->name('personalizacao.destroy');
    // ---------------------------------------------------------------------------------

    // Rota para exibir gráfico de favoritos e histórico de personalizações -- (apenas para admin)
        Route::get('/historico-personalizacoes', [PersonalizacaoController::class, 'index'])->name('historico');
        Route::get('/tabela-pedidos', [PersonalizacaoController::class, 'tabelaPedidos'])->name('tabelaPedidos');
    // ---------------------------------------------------------------------------------

    // Rota para criar a newsletter e enviar para os utilizadores -- (apenas para admin)
        Route::get('/newsletter/criar', [NewsletterController::class, 'create'])->name('newsletter.criar');
        Route::post('/newsletter/enviar', [NewsletterController::class, 'send'])->name('newsletter.enviar');
    // ---------------------------------------------------------------------------------

});

require __DIR__.'/auth.php';
