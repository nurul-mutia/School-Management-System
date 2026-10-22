<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    
    // ... method login lainnya ...

    public function logout(Request $request)
    {
        // Keluar dari guard autentikasi
        Auth::logout();

        // Invalidate dan regenerate token session demi keamanan
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect kembali ke halaman login
        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }
    
    //
}
