<?php

use PHPUnit\TextUI\XmlConfiguration\Group;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\InsumosController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\ColaborardoresController;
use App\Http\Controllers\AreaEmpresaController;
use App\Http\Controllers\MaquinariasController;
use App\Http\Controllers\ProduccionController;
use App\Http\Controllers\ProductosController;



Route::group(['middleware' => 'auth'], function () {

	Route::get('/', [HomeController::class, 'home']);
	Route::get('dashboard', function () {
		return view('dashboard');
	})->name('dashboard');

	Route::get('billing', function () {
		return view('billing');
	})->name('billing');

	Route::get('profile', function () {
		return view('profile');
	})->name('profile');

	Route::get('rtl', function () {
		return view('rtl');
	})->name('rtl');

	Route::get('user-management', function () {
		return view('laravel-examples/user-management');
	})->name('user-management');

	Route::get('tables', function () {
		return view('tables');
	})->name('tables');

	Route::get('virtual-reality', function () {
		return view('virtual-reality');
	})->name('virtual-reality');

	Route::get('static-sign-in', function () {
		return view('static-sign-in');
	})->name('sign-in');

	Route::get('static-sign-up', function () {
		return view('static-sign-up');
	})->name('sign-up');

	Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/user-profile', [InfoUserController::class, 'create']);
	Route::post('/user-profile', [InfoUserController::class, 'store']);
	Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');
});



Route::group(['middleware' => 'guest'], function () {
	Route::get('/register', [RegisterController::class, 'create']);
	Route::post('/register', [RegisterController::class, 'store']);
	Route::get('/login', [SessionsController::class, 'create']);
	Route::post('/session', [SessionsController::class, 'store']);
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
});

Route::get('/login', function () {
	return view('session/login-session');
})->name('login');

/*---- Modulo producción ---- */
Route::group(['middleware' => 'auth'], function () {
	Route::resource('produccion', ProduccionController::class)->names('produccion');
	Route::get('produccion/add/{id}/proceso', [ProduccionController::class, 'agregarProceso'])->name('produccion.add.proceso');
	Route::post('produccion/add/{id}/proceso', [ProduccionController::class, 'agregarProcesoStore'])->name('produccion.agregar.proceso');
	Route::delete('produccion/remove/proceso/{id}', [ProduccionController::class, 'removeProceso'])->name('produccion.eliminar.proceso');
});



/*---- Modulo Inventario ---- */

//Categoria
Route::group(['middleware' => 'auth'], function () {
	Route::get('/categoria', [CategoriaController::class, 'index'])->name('categoria.index');
	Route::get('/categoria/create', [CategoriaController::class, 'create'])->name('categoria.create');
	Route::post('/categoria/store', [CategoriaController::class, 'store'])->name('categoria.store');
	Route::get('/categoria/edit/{id}', [CategoriaController::class, 'edit'])->name('categoria.edit');
	Route::put('/categoria/update/{id}', [CategoriaController::class, 'update'])->name('categoria.update');
	Route::delete('/categoria/destroy/{id}', [CategoriaController::class, 'destroy'])->name('categoria.destroy');
});

//Insumos
Route::group(['middleware' => 'auth'], function () {
	Route::resource('insumos', InsumosController::class)->names('insumos');
});

//Proveedores
Route::group(['middleware' => 'auth'], function () {
	Route::resource('proveedores', ProveedoresController::class)->names('proveedores');
});

//Almacen
Route::group(['middleware' => 'auth'], function () {
	Route::resource('almacen', AlmacenController::class)->names('almacen');
	Route::get('/almacen/agregar_producto/{id}', [AlmacenController::class, 'agregarProducto'])->name('almacen.agregar.producto');
	Route::post('/almacen/add_producto/{id}', [AlmacenController::class, 'addproductoAlmacen'])->name('almacen.add.producto');
	Route::delete('/almacen/remove_producto/{id}', [AlmacenController::class, 'removeProducto'])->name('almacen.remove.producto');
});

//Maquinarias
Route::group([], function () {
	Route::resource('maquinarias', MaquinariasController::class)->names('maquinarias');
});

//Productos
Route::group([], function () {
	Route::resource('productos', ProductosController::class)->names('productos');
});

/*---- Modulo recursos humanos ---- */

//areas
Route::group(['middleware' => 'auth'], function () {
	Route::resource('area', AreaEmpresaController::class)->names('areas');
});

//colaboradoes
Route::group(['middleware' => 'auth'], function () {
	Route::resource('colaboradores', ColaborardoresController::class)->names('colaboradores');
});
