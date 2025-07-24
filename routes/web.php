<?php

use App\Http\Controllers\ContactController;
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
    return redirect()->route('contacts.index');
});
Route::get('/contacts/import', [ContactController::class, 'showImportForm'])->name('contacts.import.form');
Route::post('/contacts/import', [ContactController::class, 'import'])->name('contacts.import.process');
Route::resource('contacts', ContactController::class);
    


