<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * GET  /contact
     */
    public function index()
    {
        // resources/views/contact.blade.php
        return view('contact');
    }   // <----- tutup method index

    /**
     * POST /contact
     */
    public function send(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|string',
        ]);

        // contoh aksi: kirim email / simpan DB
        // Mail::to('support@veravia.id')->send(new ContactMail($data));

        return back()->with('success', 'Pesan Anda sudah terkirim! Terima kasih.');
    }   // <----- tutup method send
}       // <----- tutup class
