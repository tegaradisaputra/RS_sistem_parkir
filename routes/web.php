<?php

use App\Models\Transaksi;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/transaksi/{transaksi}/struk', function (Transaksi $transaksi) {
    abort_unless(auth()->user()?->isPetugas() ?? false, 403);

    return view('transaksi.struk', compact('transaksi'));
})->name('transaksi.struk');
