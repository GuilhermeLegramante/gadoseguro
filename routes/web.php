<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\ProdutorController;
use App\Http\Controllers\ActivityLogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);

// Opcional: Rota de registro (se quiser deixar aberta)
// Route::get('/registrar', [AuthController::class, 'showRegister'])->name('register');
// Route::post('/registrar', [AuthController::class, 'storeRegister']);

Route::middleware(['auth'])->group(function () {
    // Rota do Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Grupo de Marcas
    Route::prefix('marcas')->group(function () {
        // Route::get('/', [MarcaController::class, 'index'])->name('marcas.index');
        // Route::get('/novo', [MarcaController::class, 'create'])->name('marcas.create');
        // Route::post('/store', [MarcaController::class, 'store'])->name('marcas.store');

        // Rota da Busca por Desenho (Canvas)
        Route::get('/busca-visual', [MarcaController::class, 'buscaVisual'])->name('marcas.busca-visual');
        Route::post('/pesquisar-desenho', [MarcaController::class, 'pesquisar'])->name('marcas.pesquisar');
    });

    Route::resource('marcas', MarcaController::class);

    Route::get('/produtores/buscar', [ProdutorController::class, 'buscar'])->name('produtores.buscar');

    Route::resource('produtores', ProdutorController::class);

    Route::resource('municipios', MunicipioController::class);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/logs', [ActivityLogController::class, 'index'])
        ->name('logs.index')
        ->middleware('can:is-superadmin'); // Ou o middleware que você usa para o Admin

    Route::get('/marcas/{id}/titulo', [MarcaController::class, 'gerarTitulo'])->name('marcas.titulo');

    // Rota pública para qualquer um validar a marca pelo QR Code
    Route::get('/marcas/verificar/{id}', [MarcaController::class, 'verificarQrCode'])->name('marcas.verificar-qrcode');
});
