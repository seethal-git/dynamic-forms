<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\FormController;
use App\Http\Controllers\FormResponseController;


// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/' , [FormController::class , 'welcomeView']);

Route::get('/login', [AdminLoginController::class, 'showLogin']);
Route::post('/login', [AdminLoginController::class, 'login']);
Route::get('/dashboard', [AdminLoginController::class, 'showAdminDashboard'])->name('dashboard');
Route::get('/logout', [AdminLoginController::class, 'logout']);


Route::get('/formslist' , [FormController::class , 'formsList'])->name('form.formslist');
Route::get('/create' , [FormController::class , 'create'])->name('form.create');
Route::post('/submit',[FormController::class , 'store'])->name('form.create.submit');
Route::post('/edit',[FormController::class , 'editData'])->name('form.edit.submit');

// Route::delete('/{form}/delete',[FormController::class,'destroy'])->name('form.delete');
// Route::get('/{id}/restore',[FormController::class,'restore'])->name('form.restore');
Route::get('/{id}/edit',[FormController::class,'edit'])->name('form.edit');
Route::get('/{id}/force/delete',[FormController::class,'destroyPermanently'])->name('form.force.delete');
Route::get('/{form}/response',[FormController::class,'showResponses'])->name('form.response.show');
Route::get('/form/{form}',[FormResponseController::class,'index'])->name('form.show');
Route::post('/form/{form}',[FormResponseController::class,'store'])->name('form.submit');
