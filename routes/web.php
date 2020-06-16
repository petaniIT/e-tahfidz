<!--
|--------------------------------------------------------------------------
| Author ====> Muhammad Al Farizzi
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| Github ====> AlFrz27
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| Facebook ====> AlFarizzi
|--------------------------------------------------------------------------
 -->
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\information;

Route::get('/', 'welcomeController@index')->name('welcome');
Route::group(["namespace" => "auth", 'middleware' => "guest"],function() {
    Route::group(['prefix' => "login"],function() {
        Route::get('', 'authController@getLogin')->name('login');
        Route::post('', 'authController@postLogin');
    });
    Route::group(['prefix' => 'registrasi'],function() {
        Route::get('', 'authController@getRegister')->name('register');
        Route::post('', 'authController@postRegister');
    });
});

Route::group(['namespace' => "suAdmin", "prefix" => "super-admin", 'middleware' => "auth"],function() {
    Route::get('', 'suAdminController@index')->name('suAdmin.index');
    Route::post('/pengumuman', 'suAdminController@info')->name('suAdmin.info.store');
   
    Route::group(['prefix' => "pembimbing"],function(){
        Route::get('', 'suAdminController@pengajarGet')->name('suAdmin.pengajar.get');
        Route::post('', 'suAdminController@pengajarPost');
        Route::delete('/hapus-pembimbing/{pjr}', 'suAdminController@pengajarDestroy')->name('suAdmin.pengajar.destroy');
        Route::get('/edit-data-pembimbing/{pjr}', 'suAdminController@pengajarEdit')->name('suAdmin.pengajar.edit');
        Route::put('/edit-data-pembimbing/{pjr}', 'suAdminController@pengajarUpdate');
        Route::put('/ganti-password-pembimbing/{pjr}','suAdminController@editPassword')->name('suAdmin.edit.password');
   });

    Route::group(['prefix' => 'kelas'],function(){
        Route::get('', 'suAdminController@kelasGet')->name('suAdmin.kelas.get');
        Route::post('', 'suAdminController@kelasPost');
        Route::delete('/hapus-kelas/{class}', 'suAdminController@kelasDestroy')->name('suAdmin.kelas.destroy');
        Route::get('/kelas-edit/{class}', 'suAdminController@kelasEdit')->name('suAdmin.kelas.edit');
        Route::put('/kelas-edit/{class}', 'suAdminController@kelasUpdate');
        Route::get('/kelas/tambah-murid/{class}', 'suAdminController@tambahMurid')->name('suAdmin.tambah.murid');
        Route::post('/kelas/tambah-murid/{class}', 'suAdminController@tambahMurid2');
        Route::delete('/kelas/hapus-murid/{murid}', 'suAdminController@dropMurid')->name('suAdmin.kelas.drop');
    });

    Route::group(['prefix' => "registrasi-pending"],function(){
        Route::get('', 'suAdminController@pendingGet')->name('suAdmin.pending.get');
        Route::post('/{pending}', 'suAdminController@emailNotif')->name('suAdmin.confir');
    });
    
    Route::group(['prefix' => "murid"],function(){
        Route::get('', 'suAdminController@muridGet')->name('suAdmin.murid.get');
        Route::get('/catatan/{murid}', 'suAdminController@noteGet')->name('suAdmin.siswa.note');
        Route::post('/catatan/{murid}', 'suAdminController@notePost');
        Route::delete('/hapus-murid/{murid}', 'suAdminController@muridDestroy')->name('suAdmin.murid.destroy');
    });

    Route::get('/logout', function() {
        Alert::success('Berhasil', 'Kamu Berhasil Logout');
        Auth::logout();
        return redirect()->route('login');
    })->name('logout');

});
