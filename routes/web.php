<?php

use App\Http\Controllers\AccoutController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/book/{id}', [HomeController::class, 'detail'])->name('book.detail');
Route::post('/save-book-review', [HomeController::class, 'saveReview'])->name('book.saveReview');

 
Route::group(['prefix'=>'account'], function(){
   Route::group(['middleware' => 'guest'], function(){
    Route::get('register', [AccoutController::class,'register'])->name('account.register');
    Route::post('register', [AccoutController::class,'processRegister'])->name('account.processRegister');
    Route::get('login', [AccoutController::class,'login'])->name('account.login');
    Route::post('login', [AccoutController::class,'authenticate'])->name('account.authenticate');
   });

   Route::group(['middleware' => 'auth'], function(){
    Route::get('profile', [AccoutController::class,'profile'])->name('account.profile');
    Route::get('logout', [AccoutController::class,'logout'])->name('account.logout');
    Route::post('update-profile', [AccoutController::class,'updateProfile'])->name('account.updateProfile');

    Route::group(['middleware' => 'check-admin'], function(){
         Route::get('books', [BookController::class,'index'])->name('books.index');
         Route::get('books/create', [BookController::class,'create'])->name('books.create');
         Route::post('books', [BookController::class,'store'])->name('books.store');
         Route::get('books/edit/{id}', [BookController::class,'edit'])->name('books.edit');
         Route::post('books/edit/{id}', [BookController::class,'update'])->name('books.update');
         Route::delete('books', [BookController::class,'destroy'])->name('books.destroy');

         Route::get('reviews', [ReviewController::class,'index'])->name('account.reviews');
         Route::get('review/{id}', [ReviewController::class,'edit'])->name('account.reviews.edit');
         Route::post('review/{id}', [ReviewController::class,'updateReview'])->name('account.reviews.updateReview');
         Route::post('delete-reviews', [ReviewController::class,'deleteReview'])->name('account.reviews.deleteReview');
    });

    Route::get('my-reviews', [AccoutController::class,'myReviews'])->name('account.myReviews');

    Route::get('my-reviews/{id}', [AccoutController::class,'editReview'])->name('account.myReviews.editReview');

    Route::post('my-reviews/{id}', [AccoutController::class,'updateReview'])->name('account.myReviews.updateReview');

   });
});