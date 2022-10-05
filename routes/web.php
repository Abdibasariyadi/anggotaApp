<?php

use App\Http\Controllers\Permission\RoleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

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

// Route::get('/login', function () {
//     // $role = Role::find(2);
//     // $role->givePermissionTo('create post', 'delete post');

//     return view('auth.login');
// });

Auth::routes();

Route::middleware('has.role')->group(function () {



    Route::prefix('role-and-permission')->namespace('Permission')->middleware('permission:assign permission')->group(function () {

        Route::get('assignable', [App\Http\Controllers\Permissions\AssignController::class, 'create'])->name('assigns.create');
        Route::post('assignable', [App\Http\Controllers\Permissions\AssignController::class, 'store']);
        Route::get('assignable/{role}/edit', [App\Http\Controllers\Permissions\AssignController::class, 'edit'])->name('assigns.edit');
        Route::put('assignable/{role}/edit', [App\Http\Controllers\Permissions\AssignController::class, 'update']);

        // User
        Route::get('assign-user', [App\Http\Controllers\Permissions\UserController::class, 'create'])->name('assign.user.create');
        Route::post('assign-user', [App\Http\Controllers\Permissions\UserController::class, 'store']);
        Route::get('assign-user/{user}', [App\Http\Controllers\Permissions\UserController::class, 'edit'])->name('assign.user.edit');
        Route::put('assign-user/{user}', [App\Http\Controllers\Permissions\UserController::class, 'update']);

        Route::prefix('roles')->group(function () {
            Route::get('', [App\Http\Controllers\Permissions\RoleController::class, 'index'])->name('roles.index');
            Route::post('/create', [App\Http\Controllers\Permissions\RoleController::class, 'store'])->name('roles.create');
            Route::get('/{role}/edit', [App\Http\Controllers\Permissions\RoleController::class, 'edit'])->name('roles.edit');
            // Route::put('roles/{role}/edit', [App\Http\Controllers\Permissions\RoleController::class, 'update']);
            Route::delete('/{role}/delete', [App\Http\Controllers\Permissions\RoleController::class, 'destroy'])->name('roles.delete');
        });
        Route::prefix('permissions')->group(function () {
            Route::get('', [App\Http\Controllers\Permissions\PermissionController::class, 'index'])->name('permissions.index');
            Route::post('/create', [App\Http\Controllers\Permissions\PermissionController::class, 'store'])->name('permissions.create');
            Route::get('/{permission}/edit', [App\Http\Controllers\Permissions\PermissionController::class, 'edit'])->name('permissions.edit');
            // Route::put('/{permission}/edit', [App\Http\Controllers\Permissions\PermissionController::class, 'update']);
            Route::delete('/{permission}/delete', [App\Http\Controllers\Permissions\PermissionController::class, 'destroy'])->name('permissions.delete');
        });
    });

    Route::prefix('navigation')->middleware('permission:create navigation')->group(function () {
        Route::get('create', [App\Http\Controllers\NavigationController::class, 'create'])->name('navigation.create');
        Route::post('create', [App\Http\Controllers\NavigationController::class, 'store']);
    });

    Route::prefix('team')->middleware('permission:create team')->group(function () {
        Route::get('/', [App\Http\Controllers\TeamController::class, 'index'])->name('team.index');
        Route::post('create', [App\Http\Controllers\TeamController::class, 'store'])->name('team.create');
        // Route::post('create', [App\Http\Controllers\TeamController::class, 'store']);
        Route::get('/{id}/edit', [App\Http\Controllers\TeamController::class, 'edit'])->name('team.edit');
        Route::put('/{id}/edit', [App\Http\Controllers\TeamController::class, 'update']);
        Route::delete('/{role}/delete', [App\Http\Controllers\TeamController::class, 'destroy'])->name('team.delete');
    });

    Route::prefix('tps')->middleware('permission:create team')->group(function () {
        Route::get('/', [App\Http\Controllers\TpsController::class, 'index'])->name('tps.index');
        Route::post('create', [App\Http\Controllers\TpsController::class, 'store'])->name('tps.create');
        // Route::post('create', [App\Http\Controllers\TpsController::class, 'store']);
        Route::get('/{id}/edit', [App\Http\Controllers\TpsController::class, 'edit'])->name('tps.edit');
        Route::put('/{id}/edit', [App\Http\Controllers\TpsController::class, 'update']);
        Route::delete('/{tps}/delete', [App\Http\Controllers\TpsController::class, 'destroy'])->name('tps.delete');
    });

    Route::prefix('anggota')->middleware('permission:create anggota')->group(function () {
        Route::get('/', [App\Http\Controllers\AnggotaController::class, 'index'])->name('anggota.index');
        Route::get('/filter', [App\Http\Controllers\AnggotaController::class, 'filter'])->name('anggota.filter');
        Route::get('create', [App\Http\Controllers\AnggotaController::class, 'create'])->name('anggota.create');
        Route::post('create', [App\Http\Controllers\AnggotaController::class, 'store'])->name('anggota.store');
        Route::post('create', [App\Http\Controllers\AnggotaController::class, 'store'])->name('anggota.store');
        Route::get('/edit/{id}', [App\Http\Controllers\AnggotaController::class, 'edit'])->name('anggota.edit');
        Route::put('/edit/{id}', [App\Http\Controllers\AnggotaController::class, 'update']);
        Route::delete('/{id}/delete', [App\Http\Controllers\AnggotaController::class, 'destroy'])->name('anggota.delete');
        Route::post('check-nik', [App\Http\Controllers\AnggotaController::class, 'check_nik'])->name('check.nik');
        Route::get('/filter-desa/{min}/{max}', [App\Http\Controllers\DashboardController::class, 'filterDesa']);
    });

    Route::prefix('indo-region')->middleware('permission:create alamat')->group(function () {
        Route::post('get-kab', [App\Http\Controllers\IndoRegionController::class, 'getKabupaten'])->name('kab.create');
        Route::post('get-kec', [App\Http\Controllers\IndoRegionController::class, 'getKecamatan'])->name('kec.create');
        Route::post('get-desa', [App\Http\Controllers\IndoRegionController::class, 'getDesa'])->name('desa.create');
        Route::post('store-anggota', [App\Http\Controllers\IndoRegionController::class, 'getDesa'])->name('anggota.store');
    });

    Route::prefix('master-data')->middleware('permission:create master-data')->group(function () {
        Route::get('create', [App\Http\Controllers\MasterDataController::class, 'create'])->name('master-data.create');
        Route::post('create', [App\Http\Controllers\MasterDataController::class, 'store']);
    });

    Route::prefix('dashboard')->middleware('permission:show dahsboard')->group(function () {
        Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');
    });
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
