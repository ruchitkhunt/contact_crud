<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomFieldController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/',[ContactController::class, 'index'])->name('contacts.index');
Route::get('/contacts/list', [ContactController::class, 'list'])->name('contacts.list');

Route::post('/contact/store', [ContactController::class, 'store'])->name('contact.store');
Route::post('/contact/update/{id}', [ContactController::class, 'update'])->name('contact.update');
Route::get('/contact/edit/{id}', [ContactController::class, 'edit'])->name('contact.edit');
Route::delete('/contact/delete/{id}', [ContactController::class, 'destroy'])->name('contact.delete');

Route::view('/custom_fields','custom_fields.index')->name('custom_fields.index');
Route::post('/custom-fields/store', [CustomFieldController::class, 'store'])->name('custom-fields.store');
