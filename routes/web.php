<?php

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

Route::get('/test-redirect', function (Request $request) {
    if ($request->query('test_country') === 'AR') {
        return redirect()->away('https://es.wikipedia.org/wiki/Argentina');
    }
    return 'No redirect';
});
