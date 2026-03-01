<?php

use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\NewsletterController as AdminNewsletterController;
use App\Http\Controllers\Admin\AgentController as AdminAgentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas Públicas
|--------------------------------------------------------------------------
*/

Route::get('/sitemap.xml', [SitemapController::class, 'index']);
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/blog', [PostController::class, 'publicIndex'])->name('blog.index');
Route::get('/post/{slug}', [PostController::class, 'show'])->name('blog.show');

// Páginas Institucionais
Route::view('/sobre', 'sobre')->name('pages.sobre');
Route::view('/privacidade', 'privacidade')->name('pages.privacidade');
Route::get('/contato', fn () => view('contato'))->name('pages.contato');
Route::post('/contato', [ContactController::class, 'store'])->middleware('throttle:8,1')->name('pages.contato.store');
Route::post('/newsletter', [NewsletterController::class, 'store'])->middleware('throttle:8,1')->name('newsletter.subscribe');

// Cursos Públicos
Route::get('/cursos', [CourseController::class, 'publicIndex'])->name('courses.index');
Route::get('/cursos/{slug}', [CourseController::class, 'show'])->name('courses.show');

// Mercado Pago
Route::middleware('auth')->get('/mercadopago/{course:slug}', [MercadoPagoController::class, 'checkout'])->name('mercadopago.checkout');
Route::middleware('auth')->get('/mercadopago/{course:slug}/sucesso', [MercadoPagoController::class, 'success'])->name('mercadopago.success');
Route::middleware('auth')->get('/mercadopago/{course:slug}/pendente', [MercadoPagoController::class, 'pending'])->name('mercadopago.pending');
Route::post('/mercadopago/webhook', [MercadoPagoController::class, 'webhook'])->name('mercadopago.webhook');

/*
|--------------------------------------------------------------------------
| Rotas do Painel Administrativo (Admin)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Posts CRUD
    Route::resource('posts', PostController::class)->except(['show']);

    // Categories & Tags
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show', 'edit', 'update', 'create']);
    Route::resource('tags', \App\Http\Controllers\Admin\TagController::class)->only(['index', 'store', 'destroy']);

    // Cursos & Aulas
    Route::resource('courses', \App\Http\Controllers\Admin\CourseController::class);
    Route::resource('modules.lessons', \App\Http\Controllers\Admin\LessonController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy'])
        ->shallow();

    // Media Library
    Route::get('media', [MediaController::class, 'index'])->name('media.index');
    Route::post('media', [MediaController::class, 'store'])->name('media.store');
    Route::delete('media/{path}', [MediaController::class, 'destroy'])->name('media.destroy')->where('path', '.*');

    // Newsletters
    Route::resource('newsletters', AdminNewsletterController::class)->only(['index', 'destroy']);
    Route::get('messages', [ContactController::class, 'index'])->name('messages.index');
    Route::get('messages/{message}', [ContactController::class, 'show'])->name('messages.show');
    Route::delete('messages/{message}', [ContactController::class, 'destroy'])->name('messages.destroy');

    // Gestão de Usuários
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->only(['index', 'edit', 'update', 'destroy']);

    // Configurações
    Route::get('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');

    // Agentes (execução assistida)
    Route::get('agents', [AdminAgentController::class, 'index'])->name('agents.index');
    Route::post('agents/run', [AdminAgentController::class, 'store'])->name('agents.run');
});

require __DIR__.'/auth.php';
