<?php

use Illuminate\Support\Facades\Route;
use App\Models\Comment;
use App\Http\Livewire\Home;
use App\Http\Livewire\Login;
use App\Http\Livewire\Register;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

Route::get('/', function () {
    // $comment = Comment::all();
    //return view('welcome',compact('comment'));
    return view('welcome');
});

*/

Route::get('/',Home::class)->name('home')->middleware('auth');
Route::group(['middleware'=>'guest'],function(){
	Route::get('login',Login::class)->name('login');
	Route::get('register',Register::class);
});
