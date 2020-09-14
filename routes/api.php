<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Todo;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('saveList', function(Request $request) {
    $todo = Todo::find(1);
    if ($todo === null) {
        $todo = new Todo;
        $todo->id = 1;
    }
    $todo->list = implode(',', $request->list);
    $todo->save();
});


Route::get('list', function() {
    $todo = Todo::first();
    return json_encode($todo->list ?? '');
});

