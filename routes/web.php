<?php

use App\Http\Controllers\TicketController;
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

//tickets
//Route::view('/', 'welcome')->name('home');
Route::get('/', [TicketController::class, 'show'])->name('ticket.show');
Route::get('/ticket', [TicketController::class, 'store'])->name('ticket.store');
//Route::get('/ticket/{ticket}', [TicketController::class, 'show'])->name('ticket.show');
Route::get('/pasar/{ticket}/{timer}', [TicketController::class, 'update'])->name('ticket.update');
Route::get('/timer/{ticket}', [TicketController::class, 'timer'])->name('ticket.timer');
