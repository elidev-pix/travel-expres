<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

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
    
});

Route::middleware('auth')->group(function () {
    Route::resource('/student/profile', StudentController::class)->names(['index' => 'studentDashboard']);
    Route::get('/student/profile/get-form/{type}', [StudentController::class, 'getForm'])->name('get.form');
    Route::post('/save-form/{type}', [StudentController::class, 'storeForm'])->name('save.form');
});

Route::middleware('auth')->group(function(){
    Route::resource('/student/payment', PaymentController::class)->names(['index' => 'payment.student-payment']);
    Route::get('/student/payment/get-form/{type}', [PaymentController::class, 'getForm'])->name('student.get.form');
    Route::post('/student/payment/save-form/{type}', [PaymentController::class, 'storeForm'])->name('student.save.form');
    Route::get('/student/payment-update/edit/{type}', [PaymentController::class, 'edit'])->name('student.payment.edit');
    Route::put('/student/payment-update/{id}', [PaymentController::class, 'update'])->name('student.payment.update');
    Route::delete('/student/payment-delete/{id}', [PaymentController::class, 'destroy'])->name('student.payment.destroy');
});
  


Route::middleware('auth')->group(function(){
    Route::get('/profile/student-list', [ListController::class, 'getList'])->name('listing.student-list');
    
});

Route::middleware('auth')->group(function () {

    // Affiche tous les documents de l'étudiant
    Route::resource('/student/document', DocumentController::class)
        ->names(['index' => 'document.student-document']);

    // Stocke un nouveau document (après upload JS)
    Route::post('/documents', [DocumentController::class, 'store'])
        ->name('documents.store');

    // Affiche les détails d'un document
    Route::get('/documents/{document}', [DocumentController::class, 'show'])
        ->name('documents.show');

    // Met à jour un document (type / status)
    Route::put('/documents/{document}', [DocumentController::class, 'update'])
        ->name('documents.update');

    // Supprime un document
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])
        ->name('documents.destroy');
});

require __DIR__.'/auth.php';
