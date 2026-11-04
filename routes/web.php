<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
Route::view('/login', 'auth.login')->name('login');
Route::post('/login', function (Request $request) { $data = $request->validate(['email' => ['required', 'email'], 'password' => ['required']]); if (! Auth::attempt($data)) { return back()->withErrors(['email' => 'Credenciales no válidas.']); } $request->session()->regenerate(); return redirect()->intended(auth()->user()->can('acceso.finanzas') ? route('admin.finanzas.index') : '/alumno'); })->middleware('throttle:login');
Route::post('/logout', function (Request $request) { Auth::logout(); $request->session()->invalidate(); $request->session()->regenerateToken(); return redirect()->route('login'); })->middleware('auth')->name('logout');
