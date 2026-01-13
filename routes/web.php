<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;
use App\Models\Empresa;
use App\Http\Controllers\DescuentoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PromocionController;
use App\Http\Controllers\SolicitudController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('ventas.index');
    }
    $empresa = Empresa::first();
    return view('auth.login', compact('empresa'));
});

Route::get('/clear-cache', function () {
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('optimize');
    return 'Cache eliminado <a href="/">Ir al inicio</a>';
})->name('clear.cache');


Route::get('solicitudes/create', [SolicitudController::class, 'create'])->name('solicitudes.create');

Route::POST('solicitudes/store', [SolicitudController::class, 'store'])->name('solicitudes.store');

// ADMINISTRACION
Route::middleware(['auth'])->group(function () {
    // HOME
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // USUARIOS
    Route::get('users', [EmpleadoController::class, 'index'])->name('users.index');

    Route::get('users/create', [EmpleadoController::class, 'create'])->name('users.create');

    Route::get('users/show/{empleado}', [EmpleadoController::class, 'show'])->name('users.show');

    Route::get('users/edit/{empleado}', [EmpleadoController::class, 'edit'])->name('users.edit');

    Route::post('users/store', [EmpleadoController::class, 'store'])->name('users.store');

    Route::put('users/update/{empleado}', [EmpleadoController::class, 'update'])->name('users.update');

    Route::delete('users/destroy/{empleado}', [EmpleadoController::class, 'destroy'])->name('users.destroy');

    //Ver información del empleado en un pdf
    Route::get('users/informacionEmpleado/{empleado}', [EmpleadoController::class, 'informacionEmpleado'])->name('users.informacionEmpleado');

    // Configuración de cuenta
    //     contraseña
    Route::GET('configurar/cuenta/{user}', [EmpleadoController::class, 'config_cuenta'])->name('users.config');
    Route::PUT('configurar/cuenta/update/{user}', [EmpleadoController::class, 'cuenta_update'])->name('users.config_update');
    // foto de perfil
    Route::POST('configurar/cuenta/update/foto/{user}', [EmpleadoController::class, 'cuenta_update_foto'])->name('users.config_update_foto');

    // DESCUENTOS
    Route::get('descuentos', [DescuentoController::class, 'index'])->name('descuentos.index');

    Route::get('descuentos/create', [DescuentoController::class, 'create'])->name('descuentos.create');

    Route::get('descuentos/show/{descuento}', [DescuentoController::class, 'show'])->name('descuentos.show');

    Route::get('descuentos/edit/{descuento}', [DescuentoController::class, 'edit'])->name('descuentos.edit');

    Route::post('descuentos/store', [DescuentoController::class, 'store'])->name('descuentos.store');

    Route::put('descuentos/update/{descuento}', [DescuentoController::class, 'update'])->name('descuentos.update');

    Route::delete('descuentos/destroy/{descuento}', [DescuentoController::class, 'destroy'])->name('descuentos.destroy');

    Route::get('descuentos/info', [DescuentoController::class, 'info'])->name('descuentos.info');

    // EMPRESA
    Route::get('empresa', [EmpresaController::class, 'index'])->name('empresa.index');
    Route::get('empresa/edit', [EmpresaController::class, 'edit'])->name('empresa.edit');
    Route::put('empresa/update', [EmpresaController::class, 'update'])->name('empresa.update');

    // PRODUCTOS
    Route::get('productos/listadoParaVentas', [ProductoController::class, 'listadoParaVentas'])->name('productos.listadoParaVentas');

    Route::get('productos', [ProductoController::class, 'index'])->name('productos.index');

    Route::get('productos/create', [ProductoController::class, 'create'])->name('productos.create');

    Route::get('productos/show/{producto}', [ProductoController::class, 'show'])->name('productos.show');

    Route::get('productos/edit/{producto}', [ProductoController::class, 'edit'])->name('productos.edit');

    Route::post('productos/store', [ProductoController::class, 'store'])->name('productos.store');

    Route::post('productos/ingreso/{producto}', [ProductoController::class, 'ingreso'])->name('productos.ingreso');

    Route::put('productos/update/{producto}', [ProductoController::class, 'update'])->name('productos.update');

    Route::delete('productos/destroy/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');

    Route::get('productos/infoProducto/{producto}', [ProductoController::class, 'infoProducto'])->name('productos.infoProducto');

    Route::get('masVendidos', [ProductoController::class, 'masVendidos'])->name('productos.masVendidos');

    Route::get('inventario', [ProductoController::class, 'inventario'])->name('productos.inventario');

    Route::get('estadisticas', [ProductoController::class, 'estadisticas'])->name('productos.estadisticas');

    Route::post('getInventarioPdf', [ProductoController::class, 'getInventarioPdf'])->name('productos.getInventarioPdf');
    Route::get('getInventario', [ProductoController::class, 'getInventario'])->name('productos.getInventario');


    // PROMOCIONES
    Route::get('promociones', [PromocionController::class, 'index'])->name('promociones.index');

    Route::get('promociones/create', [PromocionController::class, 'create'])->name('promociones.create');

    Route::get('promociones/show/{promocion}', [PromocionController::class, 'show'])->name('promociones.show');

    Route::get('promociones/edit/{promocion}', [PromocionController::class, 'edit'])->name('promociones.edit');

    Route::post('promociones/store', [PromocionController::class, 'store'])->name('promociones.store');

    Route::put('promociones/update/{promocion}', [PromocionController::class, 'update'])->name('promociones.update');

    Route::delete('promociones/destroy/{promocion}', [PromocionController::class, 'destroy'])->name('promociones.destroy');

    // CLIENTES
    Route::get('clientes', [ClienteController::class, 'index'])->name('clientes.index');

    Route::get('clientes/create', [ClienteController::class, 'create'])->name('clientes.create');

    Route::get('clientes/show/{cliente}', [ClienteController::class, 'show'])->name('clientes.show');

    Route::get('clientes/edit/{cliente}', [ClienteController::class, 'edit'])->name('clientes.edit');

    Route::post('clientes/store', [ClienteController::class, 'store'])->name('clientes.store');

    Route::put('clientes/update/{cliente}', [ClienteController::class, 'update'])->name('clientes.update');

    Route::delete('clientes/destroy/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');

    Route::get('clientes/habilitar/{cliente}', [ClienteController::class, 'habilitar'])->name('clientes.habilitar');


    // VENTAS
    Route::get('ventas/reasignarDescuentos', [VentaController::class, 'reasignarDescuentos'])->name('ventas.reasignarDescuentos');

    Route::get('ventas', [VentaController::class, 'index'])->name('ventas.index');

    Route::get('ventas/create', [VentaController::class, 'create'])->name('ventas.create');

    Route::get('ventas/show/{venta}', [VentaController::class, 'show'])->name('ventas.show');

    Route::get('ventas/edit/{venta}', [VentaController::class, 'edit'])->name('ventas.edit');

    Route::post('ventas/store', [VentaController::class, 'store'])->name('ventas.store');

    Route::post('ventas/update/{venta}', [VentaController::class, 'update'])->name('ventas.update');

    Route::delete('ventas/destroy/{venta}', [VentaController::class, 'destroy'])->name('ventas.destroy');

    Route::get('ventas/factura/{venta}', [VentaController::class, 'factura'])->name('ventas.factura');

    // REPORTES
    Route::get('reportes/ventas', [ReporteController::class, 'ventas'])->name('reportes.ventas');
    Route::get('reportes/ventas/pdf', [ReporteController::class, 'ventas_pdf'])->name('reportes.ventas_pdf');

    // SOLICITUD DE CONTRASEÑAS
    Route::get('solicitudes', [SolicitudController::class, 'index'])->name('solicitudes.index');

    Route::POST('solicitudes/asignar/{solicitud}', [SolicitudController::class, 'asignar'])->name('solicitudes.asignar');
});
require __DIR__ . '/auth.php';
