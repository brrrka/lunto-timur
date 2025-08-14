<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResidentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ProfilNagariController;
use App\Http\Controllers\ProfilNagariContentController;
use App\Http\Controllers\StrukturOrganisasiController;
use App\Http\Controllers\NewsController as PublicNewsController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\TourismSpotController;
use App\Http\Controllers\PertanianPeternakanController;
use App\Http\Controllers\KelembagaanTaniController;
use App\Http\Controllers\LuasAreaProduksiController;
use App\Http\Controllers\PopulasiTanamanController;
use App\Http\Controllers\PopulasiTernakController;
use App\Http\Controllers\PertanianController;
use App\Http\Controllers\PeternakanController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\PublicUmkmController;
use App\Http\Controllers\HealthFacilityController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\KesehatanController;
use App\Http\Controllers\KesehatanPublicController;
use App\Http\Controllers\HukumController;
use App\Http\Controllers\HukumPublicController;
use App\Http\Controllers\DocumentController;

// Auth
Route::get('/login', function () {
    return view('pages.auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Two Factor
Route::get('/two-factor-challenge', [AuthController::class, 'showTwoFactorForm'])->name('two-factor.index');
Route::post('/two-factor-challenge', [AuthController::class, 'verifyTwoFactor'])->name('two-factor.verify');

// Dashboard (hanya bisa diakses kalau sudah login + 2FA lolos)
Route::get('/dashboard', function () {
    return "Selamat datang di Dashboard!";
})->middleware(['auth', 'twofactor']);

    

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'role:Admin,User'])
    ->name('pages.dashboard');

// Resident
Route::get('/resident', [ResidentController::class, 'index'])->middleware('role:Admin')->name('pages.resident.index');;              
Route::get('/resident/create', [ResidentController::class, 'create'])->middleware('role:Admin')->name('resident.index');;
Route::get('/resident/{id}/edit', [ResidentController::class, 'edit'])->middleware('role:Admin')->name('resident.edit');
Route::post('/resident', [ResidentController::class, 'store'])->middleware('role:Admin')->name('resident.store');
Route::put('/resident/{id}', [ResidentController::class, 'update'])->middleware('role:Admin');
Route::delete('/resident/{id}', [ResidentController::class, 'destroy'])->middleware('role:Admin');

// User
Route::get('/account-request', [UserController::class, 'accountRequestView'])->middleware('role:Admin')->name('account.request');
Route::post('/account-request/{id}', [UserController::class, 'approve'])->middleware('role:Admin')->name('account.approve');
Route::patch('/account-request/{id}', [UserController::class, 'reject'])->middleware('role:Admin')->name('account.reject');

// Profile
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
});
Route::get('/profile/change-password', [UserController::class, 'editPassword'])->name('change-password')->middleware('auth');
Route::put('/profile/change-password', [UserController::class, 'updatePassword'])->name('change-password.update')->middleware('auth');

// Complaint
Route::get('/complaint', [ComplaintController::class, 'index'])->middleware('role:Admin,User');              
Route::get('/complaint/create', [ComplaintController::class, 'create'])->middleware('role:User');
Route::get('/complaint/{id}/edit', [ComplaintController::class, 'edit'])->middleware('role:User')->name('complaint.edit');
Route::post('/complaint', [ComplaintController::class, 'store'])->middleware('role:User')->name('complaint.store');
Route::put('/complaint/{id}', [ComplaintController::class, 'update'])->middleware('role:User');
Route::delete('/complaint/{id}', [ComplaintController::class, 'destroy'])->middleware('role:User')->name('complaint.destroy');;
Route::patch('/complaint/update-status/{id}', [ComplaintController::class, 'updateStatus'])->middleware('role:Admin')->name('complaint.updateStatus');

// Profile Nagari Content
 Route::get('/profile-nagari-content', [ProfilNagariContentController::class, 'index'])->middleware('role:Admin')->name('profile-nagari-content.index');
 // Rute untuk Visi & Misi
 Route::get('/profile-nagari-content/edit-visi-misi', [ProfilNagariContentController::class, 'editVisiMisi'])->middleware('role:Admin')->name('profile-nagari-content.edit');
 Route::put('/profile-nagari-content/edit-visi-misi', [ProfilNagariContentController::class, 'updateVisiMisi'])->middleware('role:Admin')->name('profile-nagari-content.update');
 // Rute untuk Struktur Organisasi
 Route::get('/struktur-organisasi', [ProfilNagariContentController::class, 'indexStrukturOrganisasi'])->middleware('role:Admin')->name('struktur-organisasi.index');
 Route::get('/struktur-organisasi/create', [ProfilNagariContentController::class, 'createStrukturOrganisasi'])->middleware('role:Admin')->name('struktur-organisasi.create');
 Route::post('/struktur-organisasi', [ProfilNagariContentController::class, 'storeStrukturOrganisasi'])->middleware('role:Admin')->name('struktur-organisasi.store');
 Route::get('/struktur-organisasi/{id}/edit', [ProfilNagariContentController::class, 'editStrukturOrganisasi'])->middleware('role:Admin')->name('struktur-organisasi.edit');
 Route::put('/struktur-organisasi/{id}', [ProfilNagariContentController::class, 'updateStrukturOrganisasi'])->middleware('role:Admin')->name('struktur-organisasi.update');
 Route::delete('struktur-organisasi/{id}', [ProfilNagariContentController::class, 'destroyStrukturOrganisasi'])->middleware('role:Admin')->name('struktur-organisasi.destroy');

// News
Route::resource('news', NewsController::class)->middleware('role:Admin');

// Gallery
Route::resource('gallery', GalleryController::class)->middleware('role:Admin');

// Tourism Spot
Route::resource('tourism-spots', TourismSpotController::class)->middleware('role:Admin');

// Pertanian dan Peternakan
Route::get('/pertanian-peternakan', [PertanianPeternakanController::class, 'index'])->middleware('role:Admin')->name('pertanian-peternakan.index');
// Kelembagaan Tani
Route::resource('kelembagaan-tani', KelembagaanTaniController::class)->middleware('role:Admin');
// Luas Area Produksi
Route::resource('luas-area-produksi', LuasAreaProduksiController::class)->middleware('role:Admin');
// Populasi Tanaman
Route::resource('populasi-tanaman', PopulasiTanamanController::class)->middleware('role:Admin');
// Populasi Ternak
Route::resource('populasi-ternak', PopulasiTernakController::class)->middleware('role:Admin');

// UMKM
Route::resource('umkms', UmkmController::class)->middleware('role:Admin'); 

// Kesehatan
Route::get('/health', [KesehatanController::class, 'index'])->middleware('role:Admin')->name('health.index');
// Fasilitas Layanan Kesehatan
Route::resource('health-facilities', HealthFacilityController::class)->middleware('role:Admin');
// Data Penyakit
Route::resource('diseases', DiseaseController::class)->middleware('role:Admin');

// Hukum
Route::get('/law', [HukumController::class, 'index'])->middleware('role:Admin')->name('law.index');

// Kontak Hukum
Route::get('/law/legal-contact-edit', [ProfilNagariContentController::class, 'editLegalContact'])->middleware('role:Admin')->name('law.legal-contact-edit'); 
Route::put('/law/legal-contact-edit', [ProfilNagariContentController::class, 'updateLegalContact'])->middleware('role:Admin')->name('law.contact.update'); 
// Dokumen 
Route::resource('documents', DocumentController::class)->middleware('role:Admin');
  


// Beranda Public
Route::get('/', [LandingPageController::class, 'LandingPageView'])->name('index');

// Profil Nagari
Route::get('/profil-nagari', [ProfilNagariController::class, 'ProfilNagariView'])->name('profil-nagari');
Route::get('/perangkat-nagari', [ProfilNagariController::class, 'perangkatNagariView'])->name('perangkat-nagari');
Route::get('/sejarah-nagari', [ProfilNagariController::class, 'sejarahNagariView'])->name('sejarah-nagari');

// Berita
Route::get('/berita', [PublicNewsController::class, 'indexPublic'])->name('berita.index');
Route::get('/berita/show/{slug}', [PublicNewsController::class, 'showPublic'])->name('berita.show');

// Galeri
Route::get('/galeri', [GalleryController::class, 'indexPublic'])->name('galeri.index');

// Wisata
Route::get('/wisata', [TourismSpotController::class, 'indexPublic'])->name('wisata.index'); // Untuk daftar semua wisata
Route::get('/wisata/{tourismSpot:slug}', [TourismSpotController::class, 'showPublic'])->name('wisata.show'); // Untuk detail wisata

// Pertanian
Route::get('/pertanian', [PertanianController::class, 'indexPublic'])->name('user.pages.pertanian.index');
Route::get('/pertanian/kelembagaan-tani', [PertanianController::class, 'kelembagaanTaniPublic'])->name('user.pages.pertanian.kelembagaan-tani');
Route::get('/pertanian/luas-area-produksi', [PertanianController::class, 'luasAreaProduksiPublic'])->name('user.pages.pertanian.luas-area-produksi');
Route::get('/pertanian/populasi-tanaman', [PertanianController::class, 'populasiTanamanPublic'])->name('user.pages.pertanian.populasi-tanaman');
Route::get('/peternakan', [PeternakanController::class, 'populasiTernakPublic'])->name('user.pages.peternakan.index');

// UMKM
Route::get('/umkm', [PublicUmkmController::class, 'indexPublic'])->name('user.pages.umkm.index');

// Kesehatan
Route::get('/kesehatan', [KesehatanPublicController::class, 'indexPublic'])->name('user.pages.kesehatan.index');

// Hukum
Route::get('/hukum', [HukumPublicController::class, 'indexPublic'])->name('user.pages.hukum.index');
Route::get('/hukum/download/{document:slug}', [HukumPublicController::class, 'downloadDocument'])->name('hukum.download');
Route::get('/hukum/dokumen/{document:slug}', [HukumPublicController::class, 'showDocument'])->name('user.pages.hukum.show'); // Opsional: Halaman review dokumen
