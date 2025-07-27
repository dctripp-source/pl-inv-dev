<?php

use App\Http\Controllers\Api\BusinessApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public API endpoints
Route::prefix('v1')->group(function () {
    Route::get('/businesses', [BusinessApiController::class, 'index']);
    Route::get('/businesses/{slug}', [BusinessApiController::class, 'show']);
    Route::get('/categories', [BusinessApiController::class, 'categories']);
    
    // Statistics endpoint
    Route::get('/stats', function () {
        return response()->json([
            'total_businesses' => \App\Models\Business::approved()->count(),
            'total_categories' => \App\Models\Category::active()->count(),
            'total_cities' => \App\Models\Business::approved()->distinct('city')->count('city'),
            'latest_businesses' => \App\Models\Business::with(['categories', 'primaryImage'])
                                                            ->approved()
                                                            ->latest('approved_at')
                                                            ->limit(5)
                                                            ->get()
        ]);
    });
});