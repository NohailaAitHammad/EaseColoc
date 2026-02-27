<?php

use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    $colocations = auth()->user()->colocations;
    return view('dashboard', compact('colocations'));
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // colocations
    Route::resource('colocations', ColocationController::class);
    Route::get('colocations/cancel/{colocation}', [ColocationController::class, 'cancel'])->name('colocations.cancel');

    // categories
    Route::resource('colocations.categories', CategorieController::class)->scoped([
        'categorie' => 'id'
    ]);

    //depenses
    Route::resource('colocations.depenses', DepenseController::class)->scoped([
        'depense' => 'id'
    ]);


    // invitation
    Route::get('invitations/invite/{colocation}', [InvitationController::class, 'invite'])->name('invitations.invite');
    Route::post('invitations/stored/{colocation}', [InvitationController::class, 'stored'])->name('invitations.stored');
    Route::get('invitations/{token}', [InvitationController::class, 'show'])
        ->name('invitations.show')
        ->where('token', '.*');
    Route::resource('invitations', InvitationController::class);
    Route::post('invitations/{token}/accept', [InvitationController::class, 'accept'])
        ->name('invitations.accept');

    Route::post('invitations/{token}/decline', [InvitationController::class, 'decline'])
        ->name('invitations.decline');








});

require __DIR__.'/auth.php';
