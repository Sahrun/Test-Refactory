<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user', 'UserController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/room', 'RoomController@index')->middleware(['auth'])->name('room');

Route::get('/room/create', 'RoomController@create')->middleware(['auth']);

Route::post('/room/store', 'RoomController@store')->middleware(['auth']);

Route::get('/booking/now/', 'BookingController@create')->middleware(['auth']);

Route::post('/booking/now', 'BookingController@now')->middleware(['auth']);

Route::get('/booking/view','BookingController@show')->middleware(['auth']);

Route::post('/booking/inout','BookingController@inout')->middleware(['auth']);

Route::get('/booking','BookingController@index')->middleware(['auth'])->name('booking');


Route::get('put-get-stream/{filename}', function($filename) {
  $filePath = public_path($filename);
  $dir = '/';
  $recursive = false; 
  $contents = collect(Storage::disk('google')->listContents($dir, $recursive));

  $file = $contents
      ->where('type', '=', 'file')
      ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
      ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
      ->first();

  $readStream = Storage::disk('google')->getDriver()->readStream($file['path']);

  return response()->stream(function () use ($readStream) {
      fpassthru($readStream);
  }, 200, [
      'Content-Type' => $file['mimetype'],
  ]);

})->name('storage');

Route::get('/sendMAil', 'BookingController@TestSendMail');
Route::get('/sendMAil1', 'BookingController@TestSendMail1');