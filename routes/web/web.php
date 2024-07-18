<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => response()->json(['message' => 'The app works!']))->name('app');