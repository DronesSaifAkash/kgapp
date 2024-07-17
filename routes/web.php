<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\RegistrationController;

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


Route::get('/registration', [RegistrationController::class, 'registerChildForm'])->name('registration_form');
Route::post('/submit-children', [RegistrationController::class, 'registerForm_submit'])->name('register_submit');
Route::get('/get-states/{countryId}', [RegistrationController::class, 'getStates']);
Route::get('/thank-you', [RegistrationController::class, 'showThankYou'])->name('registration.thankyou');


Route::get('/children', [ChildController::class, 'listChildren'])->name('listChildren');
Route::get('/children/{id}', [ChildController::class, 'showChildDetails'])->name('child.details');
Route::put('/children/{id}/update-pickup-persons', [ChildController::class, 'updatePickupPersons'])->name('update_pickup_persons');


Route::get('/child/{id}', [ChildController::class, 'showChildDetails'])->name('child.details');
Route::post('/child/{id}', [ChildController::class, 'updateChildDetails']);
// routes/web.php
Route::post('/child/{id}/pickup-person', [ChildController::class, 'addPickupPerson'])->name('child.addPickupPerson');
Route::delete('/child/{id}/pickup-person/{personId}', [ChildController::class, 'removePickupPerson'])->name('child.removePickupPerson');


