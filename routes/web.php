<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'home'])->name('home');

Route::get('/dashboard',[SiteController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // colocations
    Route::resource('colocations', ColocationController::class);

    Route::get('colocations/cancel/{colocation}', [ColocationController::class, 'cancel'])->name('colocations.cancel');

    Route::post('colocations/{colocation}/quiter', [ColocationController::class, 'quiter'])->name('colocations.quiter');

    Route::post('colocations/{colocation}/retirer/{user}', [ColocationController::class, 'retirer'])->name('colocations.retirer');

    // categories
    Route::resource('colocations.categories', CategorieController::class)->scoped([
        'categorie' => 'id'
    ]);

    //depenses
    Route::resource('colocations.depenses', DepenseController::class)->scoped([
        'depense' => 'id'
    ]);

    Route::get('colocations/{colocation}/depenses/{depense}/{user}', [DepenseController::class, 'payer'])->name('colocations.depenses.payer');
    //Route::get('colocations/{colocation}/depenses/stats', [DepenseController::class, 'stats'])->name('colocations.depenses.stats');

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

    // admin
    Route::get('/admin',[SiteController::class, 'index'])->name('admin.index');

    Route::post('admin//user/{user}/ban', [SiteController::class, 'toggleBan'])->name('admin.toggleBan');


});



require __DIR__.'/auth.php';
