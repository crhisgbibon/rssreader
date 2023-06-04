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
})->name('rssreader');

Route::controller(ControllerRSSReader::class)->group(function () {

  // normal users - reader page
  Route::get('/reader', 'index')->name('rssreaderreader');

  Route::post('/GETRSS', 'GetRSS')->name('rssreaderGetRss');
  Route::post('/OFFSETMINUS', 'OffsetMinus')->name('rssreaderOffsetMinus');
  Route::post('/OFFSETPLUS', 'OffsetPlus')->name('rssreaderOffsetPlus');

  Route::post('/WORDS', 'Words')->name('rssreaderWords');
  Route::post('/SEARCHWORD', 'SearchWord')->name('rssreaderSearchWord');

  Route::post('/TICK', 'GetTick')->name('rssreaderGetTick');

  // need to be logged in to save items or access profile pages
  Route::post('/SAVEITEM', 'SaveItem')->middleware(['auth', 'verified'])->name('rssreaderSaveItem');

  // normal users - saved items page
  Route::get('/user', 'profile')->middleware(['auth', 'verified'])->name('rssreaderprofile');

  Route::post('/GETSAVED', 'GetSaved')->middleware(['auth', 'verified'])->name('rssreaderGetSaved');
  Route::post('/DELETESAVED', 'DeleteSaved')->middleware(['auth', 'verified'])->name('rssreaderDeleteSaved');


  // admin only - manage sources
  Route::get('/sources', 'sources')->middleware(['auth', 'verified', 'is_admin'])->name('rssreadersources');
  Route::post('/SOURCE', 'EditSource')->middleware(['auth', 'verified', 'is_admin'])->name('rssreaderEditSource');
  Route::post('/DELETESOURCE', 'DeleteSource')->middleware(['auth', 'verified', 'is_admin'])->name('rssreaderDeleteSource');
  Route::post('/FORCE', 'ForceUpdate')->middleware(['auth', 'verified', 'is_admin'])->name('rssreaderForceUpdate');
  Route::post('/TEST', 'TEST')->middleware(['auth', 'verified', 'is_admin'])->name('rssreaderTEST');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
