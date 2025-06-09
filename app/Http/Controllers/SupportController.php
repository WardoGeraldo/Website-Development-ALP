<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Support;

class SupportController extends Controller
{
    public function show()
    {
        return view('support');
    }

    public function store(Request $request)
    {
        // Validasi input form
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        // Simpan ke database
        Support::create($validated);

        // Kasih response
        return response()->json(['success' => true]);
    }
}
