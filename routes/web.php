<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
    Route::get('/usuarios/crear', [UserController::class, 'create'])->name('users.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');
    Route::get('/usuarios/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/usuarios/{user}/editar', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/proyectos', [ProjectController::class, 'index'])->name('projects.index'); // Mostrar todos los proyectos
    Route::get('/proyectos/crear', [ProjectController::class, 'create'])->name('projects.create'); // Formulario para crear un nuevo proyecto
    Route::post('/proyectos', [ProjectController::class, 'store'])->name('projects.store'); // Almacenar un nuevo proyecto
    Route::get('/proyectos/{project}', [ProjectController::class, 'show'])->name('projects.show'); // Mostrar un proyecto específico
    Route::get('/proyectos/{project}/editar', [ProjectController::class, 'edit'])->name('projects.edit'); // Formulario para editar un proyecto
    Route::put('/proyectos/{project}', [ProjectController::class, 'update'])->name('projects.update'); // Actualizar un proyecto existente
    Route::delete('/projects/{id}', [CommentController::class, 'destroy'])->name('comments.destroy'); // Eliminar un comentario

    Route::get('/comentarios', [CommentController::class, 'index'])->name('comments.index'); // Mostrar todos los comentarios
    Route::get('/comentarios/crear', [CommentController::class, 'create'])->name('comments.create'); // Formulario para crear un nuevo comentario
    Route::post('/comentarios', [CommentController::class, 'store'])->name('comments.store'); // Almacenar un nuevo comentario
    Route::get('/comentarios/{comment}', [CommentController::class, 'show'])->name('comments.show'); // Mostrar un comentario específico
    Route::get('/comentarios/{comment}/editar', [CommentController::class, 'edit'])->name('comments.edit'); // Formulario para editar un comentario
    Route::put('/comentarios/{comment}', [CommentController::class, 'update'])->name('comments.update'); // Actualizar un comentario
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy'); // Eliminar un comentario

    // Rutas para archivos
    Route::get('/archivos', [FileController::class, 'index'])->name('files.index'); // Listar archivos
    Route::get('/archivos/crear', [FileController::class, 'create'])->name('files.create'); // Formulario para crear archivo
    Route::post('/archivos', [FileController::class, 'store'])->name('files.store'); // Subir archivo
    Route::get('/archivos/{file}', [FileController::class, 'show'])->name('files.show'); // Ver archivo
    Route::get('/files/{file}', [FileController::class, 'download'])->name('files.download'); // Descargar archivo

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__.'/auth.php';
