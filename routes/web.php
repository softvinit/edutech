<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\LiveClassController;
use App\Http\Controllers\ElibraryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\user_frontend\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoCourseController;
use App\Http\Controllers\UploadMonitorController;

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

Route::get('/login', function () {
    return view('auth.login');
});
Route::post('login', [LoginController::class, 'login'])->name('login');

// Route::get('login', function () {
//     return view('dashboard');
// });

Route::get('/', [HomeController::class, 'index'])->name('index');


Route::middleware(['auth'])->group(function () {

    Route::get('ins/content', [LiveClassController::class, 'index'])->name('liveclass');
    Route::post('ins/content', [LiveClassController::class, 'store'])->name('liveclass.store');
    Route::get('/live-classes/{id}', [LiveClassController::class, 'show'])->name('liveClasses.show');
    Route::get('/live-classes/data', [LiveClassController::class, 'getData'])->name('liveClasses.data');
    // Route for editing a live class
    Route::get('/live-Class/{id}/edit', [LiveClassController::class, 'edit'])->name('liveClasses.edit');

    // Route for updating a live class (this will handle the form submission)
    Route::put('/live-Classes/{id}', [LiveClassController::class, 'update'])->name('liveclass.update');

    // Route for deleting a live class
    Route::delete('/live-Classes/{id}', [LiveClassController::class, 'destroy'])->name('liveClasses.destroy');
    Route::get('/live-classes/clear-session', [LiveClassController::class, 'resetSession'])->name('liveclass.reset');

    // In get Category route , fetching category 1 and category 2
    Route::get('/live-classes/cat1/{categoryId}', [LiveClassController::class, 'getCategoryOptions'])->name('liveclass.getCategoryOptions');
    Route::get('/live-classes/cat2/{categoryId}', [LiveClassController::class, 'getCategory_2Options'])->name('liveclass.getCategory_2Options');

    Route::get('ins/video', [VideoCourseController::class, 'index'])->name('videocourse');
    Route::post('ins/video', [VideoCourseController::class, 'store'])->name('videocourse.store');
    Route::get('ins/video/edit/{id}', [VideoCourseController::class, 'edit'])->name('videocourse.edit');
    // Route for the update method in VideoCourseController
    Route::put('/videocourses/{id}', [VideoCourseController::class, 'update'])->name('videocourse.update');
    Route::get('/videocourses/{id}/videos', [VideoCourseController::class, 'showVideos'])->name('videocourse.showVideos');
    Route::delete('/videos/{id}', [VideoCourseController::class, 'destroy'])->name('videocourse.deleteVideo');
    Route::post('ins/video/upload', [VideoCourseController::class, 'uploadVideos'])->name('videocourse.uploadVideos');
    Route::delete('/ins/video/delete_multiple', [VideoCourseController::class, 'deleteMultiple'])->name('videocourse.deleteMultiple');

    Route::get('ins/login', [LoginController::class, 'insindex'])->name('inslogin');

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('ins/dashboard', [InstituteController::class, 'index'])->name('insdashboard');
    /***  For Course routes ***/
    Route::get('addlevel0', [InstituteController::class, 'categoryLevel0'])->name('addlevel0');
    Route::post('addlevel0', [InstituteController::class, 'storeLevel0'])->name('storelevel0');
    // Route::get('course_list', [InstituteController::class, 'level0List'])->name('course_list');
    Route::get('category_level0/data', [InstituteController::class, 'getLevel0Data'])->name('category_level0.data');
    // Route::get('course_list/data', [InstituteController::class, 'getLevel0Data'])->name('courses.data');
    Route::get('edit_level0/{id}', [InstituteController::class, 'editLevel0'])->name('edit_level0');
    Route::put('update_level0/{id}', [InstituteController::class, 'updateLevel0'])->name('update_level0');
    Route::delete('delete_level0/{id}', [InstituteController::class, 'deleteLevel0'])->name('delete_level0');
    /***  For Category routes ***/
    Route::get('category_level1', [InstituteController::class, 'CategoryLevel1'])->name('category_level1');
    Route::get('course_category/data', [InstituteController::class, 'getLevel1Data'])->name('course_category.data');
    Route::post('store_category', [InstituteController::class, 'StoreLevel1'])->name('store_level1');
    Route::get('edit_level1/{id}', [InstituteController::class, 'editLevel1'])->name('edit_level1');
    Route::put('edit_level1/{id}', [InstituteController::class, 'updateLevel1'])->name('update_level1');
    Route::delete('delete_level1/{id}', [InstituteController::class, 'deleteLevel1'])->name('delete_level1');
    /***  For Sub Category routes ***/
    Route::get('course_subcategory', [InstituteController::class, 'courseSubCategory'])->name('course_subcategory');
    Route::post('store_subcategory', [InstituteController::class, 'StoreSubCategory'])->name('store_subcategory');
    Route::get('course_subcategory/data', [InstituteController::class, 'getSubcategoriesData'])->name('subcategory.data');
    Route::get('edit_subcategory/{id}', [InstituteController::class, 'editSubCategory'])->name('edit_subcategory');
    Route::put('update_subcategory/{id}', [InstituteController::class, 'updateSubcategory'])->name('update_subcategory');
    Route::delete('delete_subcategory/{id}', [InstituteController::class, 'deleteSubcategory'])->name('delete_subcategory');

    Route::resource('roles', RoleController::class);

    // ---------------------------------------------------------------------------E Library Section Routes

    // use App\Http\Controllers\ElibraryController;

    Route::get('/ins/content/e-library', [ElibraryController::class, 'index'])->name('elibrary');
    Route::post('/ins/content/e-library/store', [ElibraryController::class, 'store'])->name('elibrary.store');
    Route::get('/ins/content/e-library/edit/{id}', [ElibraryController::class, 'edit'])->name('elibrary.edit');
    Route::get('/ins/content/e-library/show', [ElibraryController::class, 'show'])->name('elibrary.show');
    Route::put('/ins/content/e-library/update/{id}', [ElibraryController::class, 'update'])->name('elibrary.update');
    Route::get('/ins/content/e-library/files/{id}', [ElibraryController::class, 'files'])->name('elibrary.files');

    // Route for deleting multiple eLibrary files
    Route::delete('/delete-multiple', [ElibraryController::class, 'deleteMultiple'])->name('elibrary.deleteMultiple');
    Route::post('/elibrary/upload-files', [ElibraryController::class, 'uploadFiles'])->name('elibrary.uploadFiles');
    // Route::get('/ins/content/e-library', [ElibraryController::class, 'index'])->name('elibrary.store');
    // Route::get('/upload-monitor', [UploadMonitorController::class, 'index'])->name('upload.monitor');
    Route::resource('users', UserController::class);
});

// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
