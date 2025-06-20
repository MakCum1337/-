<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\bookController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\genre;
use App\Models\User;

Route::get('/', [bookController::class, 'home'])->name('home');


// autorisation

Route::get('/sign_in', function(){
    return view('profile_settings.authorisation.sign_in');
})->name('sign_in');
Route::get('/registration', function(){
    return view('profile_settings.authorisation.registration');
})->name('registration');
Route::post('/signing', [UserController::class, 'sign_in'])->name('signing');
Route::post('/register', [UserController::class, 'register'])->name('register');

// verification

Route::get('/email/verify', function () {
    return view('profile_settings.authorisation.verification');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');
use Illuminate\Http\Request;

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:3,1'])->name('verification.send');


// adding

Route::get('/add/genre', function(){
    return view('admin.add.genre');
})->name('add_genre');
Route::get('/add/book', function(){
    $genres = genre::all();
    return view('admin.add.book', compact('genres'));
})->name('add_book');

Route::post('/adding/book', [bookController::class, 'adding_book'])->name('adding_book');
Route::post('/adding/genre', [bookController::class, 'adding_genre'])->name('adding_genre');
Route::post('/sending_review', [bookController::class, 'send_review'])->name('send_review');



// profile

Route::get('/profile', function(){
    return view('profile_settings.profile');
})->name('profile');






// genres

Route::get('/edit/genre/{genre_id}', [bookController::class, 'edit_genre'])->name('edit_genre');
Route::post('/genre/update', [bookController::class, 'update_genre'])->name('update_genre');


// edit

Route::get('/edit/book/{book_id}',[bookController::class, 'edit_book'])->name('edit_book');
Route::post('/book/update', [bookController::class, 'update_book'])->name('update_book');
Route::get('/edit/physical_book/{phys_book_id}',[bookController::class, 'edit_physical_book'])->name('edit_physical_book');
Route::post('/physical_book/update', [bookController::class, 'update_physical_book'])->name('update_physical_book');


// delete

Route::get('/delete/physical_book/{physical_book}', [bookController::class, 'delete_physical_book'])->name('delete_physical_book');
Route::get('/delete/book/{book}', [bookController::class, 'delete_book'])->name('delete_book');
Route::get('/delete/genre/{genre}', [bookController::class, 'delete_genre'])->name('delete_genre');
Route::get('/deleting_genre/{genre}', [bookController::class, 'deleting_genre'])->name('deleting_genre');


// outputs

Route::get('/output/genre/{genre_id}', [bookController::class, "select_genre"])->name('select_genre');
Route::get('/outputs/physical_book/{physical_book}', [bookController::class, 'select_physical_book'])->name('select_physical_book');
Route::get('/outputs/book/{book}', [bookController::class, 'select_book'])->name('select_book');
Route::get('/having_books', [bookController::class, 'see_my_books'])->name('see_my_books');
Route::get('/storage/books/{book_id}', [bookController::class, 'read_book'])->name('read_book');


// buying

Route::get('/adding_to_cart/physial/{book}', [bookController::class, 'add_to_cart_physical'])->name('add_to_cart_physical');
Route::get('/adding_to_cart/{book}', [bookController::class, 'add_to_cart'])->name('add_to_cart');
Route::get('/buy', [bookController::class, 'buy_books'])->name('buy_books');

Route::get('/get_admin', function(){
    Auth::user()->admin = true;
    return redirect()->route('home');
})->name('get_admin');