<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* User Note Routes */
// 1. Get all user notes (GET) /api/user/notes
// 2. Show specific note by user (GET) /api/user/notes/{id}
// 3. Create note (POST) /api/user/notes
// 4. Update specific note (PUT) /api/user/notes/{id}
// 5. Delete specific note (DELETE) /api/user/notes/{id}

/* Unauthorized Route */
Route::get('/unauthorized', function() {
    return response()->json(['error' => "Unauthorized"], 401);
})->name('unauthorized');

/* Login - Provide Email and Password to Receive Auth Token */
Route::post('/login', function(Request $request) {
    $creds = $request->only(['email', 'password']);
    
    // Basic Auth
    Auth::attempt($creds);

    // Generate Token (Using Laravel Sanctum)
    $token = $request->user()->createToken('token-name');
    return response()->json(['token' => $token->plainTextToken]);
})->name('login');

/* User Note Routes */
Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'user'], function() {
    // Note Resource Routes
    Route::apiResource('notes', NoteController::class);

    // Logout Route
    Route::get('/logout', function(Request $request) {
        // Revoke the token that was used to authenticate the current request...
        $request->user()->currentAccessToken()->delete();
    
        return response()->json(['message' => "User successfully logged out."]);
    })->name('logout');
});
