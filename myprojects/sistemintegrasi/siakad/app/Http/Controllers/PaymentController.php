<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function tampil()
    {
        // Menggunakan nama variabel $tagihan agar cocok dengan file blade
        $tagihan = Payment::with('mahasiswa')->get(); 
        
        // Kirim $tagihan ke view 'payment'
        return view('payment', compact('tagihan'));
    }
}