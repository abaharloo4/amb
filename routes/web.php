<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/_ui');
});

Route::get('/_ui', function () {
    return view('ui.catalog');
})->name('ui.catalog');

