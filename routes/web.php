<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::prefix('biznisi')->name('business.')->group(function () {
    Route::get('/', [BusinessController::class, 'index'])->name('index');
    Route::get('/prijavi', [BusinessController::class, 'create'])->name('create');
    Route::post('/prijavi', [BusinessController::class, 'store'])->name('store');
    Route::get('/uspeh', [BusinessController::class, 'success'])->name('success');
    Route::get('/{slug}', [BusinessController::class, 'show'])->name('show');

    Route::post('/upload-sliku', [BusinessController::class, 'uploadImage'])->name('upload.image');
    Route::delete('/obrisi-sliku', [BusinessController::class, 'deleteImage'])->name('delete.image');
    Route::get('/uploadovane-slike', [BusinessController::class, 'getUploadedImages'])->name('uploaded.images');
    Route::delete('/obrisi-sve-slike', [BusinessController::class, 'clearUploadedImages'])->name('clear.images');
});

Route::prefix('kategorije')->name('category.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/{slug}', [CategoryController::class, 'show'])->name('show');
});	

Route::get('/debug-session', function() {
    return response()->json([
        'session_id' => session()->getId(),
        'uploaded_images' => session('uploaded_images', []),
        'uploaded_images_count' => count(session('uploaded_images', [])),
        'csrf_token' => csrf_token(),
        'all_session' => session()->all()
    ]);
});

Route::post('/debug-business-store', function(\Illuminate\Http\Request $request) {
    \Log::info('=== DEBUG BUSINESS STORE ===');
    \Log::info('All request data: ', $request->all());
    \Log::info('Files: ', $request->allFiles());
    \Log::info('Session data: ', session()->all());
    
    return response()->json([
        'success' => true,
        'message' => 'Debug successful',
        'request_data' => $request->all(),
        'session_images' => session('uploaded_images', []),
        'validation_rules' => (new \App\Http\Requests\BusinessStoreRequest())->rules()
    ]);
});

Route::get('/debug-routes', function() {
    $routes = collect(\Route::getRoutes())->map(function($route) {
        return [
            'method' => implode('|', $route->methods()),
            'uri' => $route->uri(),
            'name' => $route->getName(),
            'action' => $route->getActionName()
        ];
    })->filter(function($route) {
        return str_contains($route['uri'], 'business') || str_contains($route['name'] ?? '', 'business');
    });
    
    return response()->json($routes);
});