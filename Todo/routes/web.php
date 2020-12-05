<?php

use App\Http\Controllers\MainController;
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

// Route::get('/sd', function () {
//     return view('welcome');
// });


Route::get('/', [MainController::class, 'main']);

Route::post('/add', [MainController::class, 'addTodo']);

Route::get('/getTodo', [MainController::class, 'getTodo']);

Route::post('/delete', [MainController::class, 'deleteTodo']);

Route::post('/complete', [MainController::class, 'completeTodo']);
