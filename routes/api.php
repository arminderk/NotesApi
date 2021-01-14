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
// 1. Get all user notes (GET) /api/user/{user_id}/notes{id}
// 2. Show specific note by user (GET) /api/user/{user_id}/notes/{id}
// 3. Create note (POST) /api/user/{user_id}/notes/create
// 4. Update specific note (PUT) /api/user/{user_id}/notes/{id}
// 5. Delete specific note (DELETE) /api/user/{user_id}/notes/{id}

Route::resource('user.notes', NoteController::class);

Route::get('/unauthorized', function() {
    return response()->json(['error' => "Unauthorized"], 401);
})->name('unauthorized');

Route::post('/login', function(Request $request) {
    $creds = $request->only(['email', 'password']);
    
    // Basic Auth
    Auth::attempt($creds);

    // To do: Generate Token (Laravel Sanctum)
})->name('login');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
