<?php
use App\Http\Controllers\WorkerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WorkerController::class, 'index']);
Route::post('/store', [WorkerController::class, 'store'])->name('store');
Route::get('/fetchall', [WorkerController::class, 'fetchAll'])->name('fetchAll');
Route::delete('/delete', [WorkerController::class, 'delete'])->name('delete');
Route::get('/edit', [WorkerController::class, 'edit'])->name('edit');
Route::post('/update', [WorkerController::class, 'update'])->name('update');
