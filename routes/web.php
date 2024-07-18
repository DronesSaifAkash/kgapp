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

Route::get('/', [RegistrationController::class, 'registerChildForm'] );
Route::get('/registration', [RegistrationController::class, 'registerChildForm'])->name('registration_form'); // for register child and pickup person
Route::post('/submit-children', [RegistrationController::class, 'registerForm_submit'])->name('register_submit'); // for submit children registration data
Route::get('/get-states/{countryId}', [RegistrationController::class, 'getStates']); // for getting the states using ajax

Route::get('/children', [ChildController::class, 'listChildren'])->name('listChildren'); // for children listing
Route::get('/children/{id}', [ChildController::class, 'showChildDetails'])->name('child.details'); // for children details
Route::put('/children/{id}/update-pickup-persons', [ChildController::class, 'updatePickupPersons'])->name('update_pickup_persons'); // for update pickup person
Route::delete('/pickup-persons/{id}', [ChildController::class, 'deletePickupPerson'])->name('delete_pickup_person'); // for delete pickup person using ajax
Route::get('/children/{id}/edit', [ChildController::class, 'children_edit'])->name('children_edit'); // for edit children information
Route::put('/children/{id}', [ChildController::class, 'updateChildDetails'])->name('update_children'); // for update children data


