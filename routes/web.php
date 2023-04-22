<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RSSReader\ControllerRSSReader;

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

Route::get('/', function(){
  return redirect('/reader');
})->middleware(['auth', 'verified'])->name('rssreader');

Route::controller(ControllerRSSReader::class)->group(function () {
  Route::get('/reader', 'index')->middleware(['auth', 'verified'])->name('rssreaderreader');
  Route::get('/sources', 'sources')->middleware(['auth', 'verified'])->name('rssreadersources');
  Route::get('/user', 'profile')->middleware(['auth', 'verified'])->name('rssreaderprofile');

  Route::post('/GETRSS', 'GetRSS')->middleware(['auth', 'verified'])->name('rssreaderGetRss');
  Route::post('/OFFSETMINUS', 'OffsetMinus')->middleware(['auth', 'verified'])->name('rssreaderOffsetMinus');
  Route::post('/OFFSETPLUS', 'OffsetPlus')->middleware(['auth', 'verified'])->name('rssreaderOffsetPlus');

  Route::post('/WORDS', 'Words')->middleware(['auth', 'verified'])->name('rssreaderWords');
  Route::post('/SEARCHWORD', 'SearchWord')->middleware(['auth', 'verified'])->name('rssreaderSearchWord');

  Route::post('/SAVEITEM', 'SaveItem')->middleware(['auth', 'verified'])->name('rssreaderSaveItem');

  Route::post('/SOURCE', 'EditSource')->middleware(['auth', 'verified'])->name('rssreaderEditSource');
  Route::post('/DELETESOURCE', 'DeleteSource')->middleware(['auth', 'verified'])->name('rssreaderDeleteSource');
  Route::post('/FORCE', 'ForceUpdate')->middleware(['auth', 'verified'])->name('rssreaderForceUpdate');
  Route::post('/TICK', 'GetTick')->middleware(['auth', 'verified'])->name('rssreaderGetTick');
  Route::post('/GETSAVED', 'GetSaved')->middleware(['auth', 'verified'])->name('rssreaderGetSaved');
  Route::post('/DELETESAVED', 'DeleteSaved')->middleware(['auth', 'verified'])->name('rssreaderDeleteSaved');
});

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
